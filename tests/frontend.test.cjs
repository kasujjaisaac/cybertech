const test = require('node:test');
const assert = require('node:assert/strict');
const fs = require('node:fs');
const vm = require('node:vm');
const path = require('node:path');
const source = name => fs.readFileSync(path.join(__dirname, '../public/js', name), 'utf8');

function classList() {
    const values = new Set();
    return { add: (...items) => items.forEach(x => values.add(x)), remove: (...items) => items.forEach(x => values.delete(x)), contains: x => values.has(x), toggle: (x, on) => on ? values.add(x) : values.delete(x) };
}

test('all theme choices persist, follow system preferences and swap product images', () => {
    const events = {};
    const buttons = ['light', 'dark', 'system'].map(theme => ({ dataset: { themeOption: theme }, attrs: {}, setAttribute(k, v) { this.attrs[k] = v; }, addEventListener(k, fn) { this[k] = fn; } }));
    const image = { dataset: { darkSrc: 'cutout.png', lightSrc: 'original.jpg' }, src: 'original.jpg', getAttribute() { return this.src; }, setAttribute(k, v) { this.src = v; } };
    const root = { dataset: {}, classList: classList() };
    const pref = { matches: false, addEventListener(k, fn) { this.change = fn; } };
    const control = { hidden: true, querySelectorAll: () => buttons };
    const saved = [];
    vm.runInNewContext(source('theme.js'), { document: { documentElement: root, querySelectorAll: q => q === '[data-theme-option]' ? buttons : [image], querySelector: q => q.startsWith('meta') ? { setAttribute() {} } : control, addEventListener(k, fn) { events[k] = fn; } }, window: { matchMedia: () => pref, localStorage: { getItem: () => 'system', setItem: (k, v) => saved.push(v) } } });
    events.DOMContentLoaded();
    assert.equal(control.hidden, false);
    buttons[1].click();
    assert.equal(root.dataset.theme, 'dark');
    assert.equal(image.src, 'cutout.png');
    assert.equal(saved.at(-1), 'dark');
    pref.change();
    assert.equal(root.dataset.theme, 'dark');
    buttons[2].click();
    assert.equal(image.src, 'original.jpg');
    pref.matches = true; pref.change();
    assert.equal(image.src, 'cutout.png');
    buttons[0].click();
    assert.equal(root.dataset.theme, 'light');
    assert.equal(buttons.filter(b => b.attrs['aria-pressed'] === 'true').length, 1);
});

test('preloader covers internal page transitions and recovers from back navigation or failed navigation', () => {
    const root = { classList: classList(), setAttribute() {}, removeAttribute() {} };
    const events = {}, timers = new Map(); let timerId = 0;
    const run = ms => { for (const [id, timer] of [...timers]) if (timer.ms === ms) { timers.delete(id); timer.fn(); } };
    vm.runInNewContext(source('preloader.js'), { Date: { now: () => 0 }, URL, document: { documentElement: root, querySelector: () => ({ complete: true }), addEventListener(k, fn) { events[k] = fn; } }, window: { location: new URL('http://localhost/'), matchMedia: () => ({ matches: false }), setTimeout(fn, ms) { timers.set(++timerId, { fn, ms }); return timerId; }, clearTimeout: id => timers.delete(id), addEventListener(k, fn) { events[k] = fn; } } });
    assert(root.classList.contains('is-preloading'));
    events.DOMContentLoaded(); run(600); run(240);
    assert(!root.classList.contains('is-preloading'));
    const click = (href, extra = {}) => events.click({ button: 0, target: { closest: () => ({ href, target: '', hasAttribute: () => false }) }, ...extra });
    click('http://localhost/products');
    assert(root.classList.contains('is-preloading'));
    events.pageshow({ persisted: true });
    assert(!root.classList.contains('is-preloading'));
    click('https://texaro.it.com/');
    assert(!root.classList.contains('is-preloading'));
    click('http://localhost/#main');
    assert(!root.classList.contains('is-preloading'));
    click('http://localhost/contact', { ctrlKey: true });
    assert(!root.classList.contains('is-preloading'));
    click('http://localhost/contact'); run(4000);
    assert(!root.classList.contains('is-preloading'));
});

test('shared site script works without optional dialogs and mobile menu closes accessibly', () => {
    const events = {}, attrs = { 'aria-expanded': 'false' }; let focused = false, resize;
    const menu = { getAttribute: k => attrs[k], setAttribute(k, v) { attrs[k] = v; }, addEventListener(k, fn) { events['menu' + k] = fn; }, focus() { focused = true; } };
    const nav = { classList: classList(), querySelectorAll: () => [] };
    vm.runInNewContext(source('site.js'), { document: { querySelector: q => q === '.menu-toggle' ? menu : q === '#main-nav' ? nav : null, querySelectorAll: () => [], addEventListener(k, fn) { events[k] = fn; } }, window: { matchMedia: () => ({ matches: false, addEventListener(k, fn) { resize = fn; } }), addEventListener() {} } });
    events.menuclick(); assert.equal(attrs['aria-expanded'], 'true');
    events.keydown({ key: 'Escape' }); assert.equal(attrs['aria-expanded'], 'false'); assert(focused);
    events.menuclick(); resize({ matches: false }); assert.equal(attrs['aria-expanded'], 'false');
    events.menuclick(); events.click({ target: { closest: () => null } }); assert.equal(attrs['aria-expanded'], 'false');
});
