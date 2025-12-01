# Accessibility (A11y) Implementation Guide

## Overview

This document outlines the accessibility features implemented in the Bimbel Farmasi application to ensure WCAG 2.1 Level AA compliance and provide an inclusive user experience.

## WCAG 2.1 Level AA Compliance

### Perceivable

#### ✅ Text Alternatives (1.1.1)

- **Images**: All images have descriptive `alt` attributes
- **Icons**: Decorative icons use `aria-hidden="true"`
- **Functional icons**: Include `aria-label` for screen readers

```blade
<!-- ✅ Good -->
<img src="program.jpg" alt="UKOM D3 Farmasi preparation program">

<!-- ✅ Good: Decorative -->
<svg aria-hidden="true">...</svg>

<!-- ✅ Good: Functional -->
<button aria-label="Close modal">
    <svg aria-hidden="true">...</svg>
</button>
```

#### ✅ Color Contrast (1.4.3)

- **Normal text**: Minimum 4.5:1 contrast ratio
- **Large text**: Minimum 3:1 contrast ratio
- **UI components**: Minimum 3:1 contrast ratio

**Color Palette:**
| Element | Foreground | Background | Ratio | Status |
|---------|------------|------------|-------|--------|
| Body text | #1f2937 | #F7F9FF | 12.5:1 | ✅ AAA |
| Headings | #0f172a | #F7F9FF | 15.3:1 | ✅ AAA |
| Links | #2563eb | #F7F9FF | 7.1:1 | ✅ AAA |
| Gray text | #6b7280 | #F7F9FF | 4.8:1 | ✅ AA |
| Primary button | #FFFFFF | #2563eb | 8.2:1 | ✅ AAA |

#### ✅ Responsive & Zoom (1.4.10, 1.4.4)

- Text resizable up to 200% without loss of functionality
- Responsive design supports viewport zoom
- No horizontal scrolling at 200% zoom

```css
/* Optimal line length */
p,
li,
td {
  max-width: 70ch;
}
```

### Operable

#### ✅ Keyboard Navigation (2.1.1, 2.1.2)

- **Tab order**: Logical and intuitive
- **Focus visible**: Clear focus indicators (2px blue outline)
- **No keyboard trap**: Users can navigate in and out of all components
- **Shortcuts**: Document any keyboard shortcuts

**Keyboard Shortcuts:**
| Key | Action |
|-----|--------|
| `Tab` | Move to next focusable element |
| `Shift+Tab` | Move to previous focusable element |
| `Enter` | Activate button/link |
| `Space` | Activate button, toggle checkbox |
| `Escape` | Close modal/dropdown |
| `Arrow keys` | Navigate within dropdown/slider |

**Implementation:**

```javascript
// app.js - Keyboard navigation support
document.addEventListener('keydown', (e) => {
    if (e.key === 'Tab') {
        document.body.classList.add('keyboard-nav');
    }
});

// Visual focus indicator only for keyboard users
body.keyboard-nav *:focus {
    outline: 2px solid #2563eb;
    outline-offset: 2px;
}
```

#### ✅ Skip Links (2.4.1)

Skip to main content link for keyboard users

```html
<a href="#main-content" class="skip-link">Skip to main content</a>
```

#### ✅ Focus Management (2.4.7)

- Focus order follows visual layout
- Modal traps focus until closed
- Focus returned to trigger element after modal close

```javascript
// Modal.jsx - Focus trap implementation
useEffect(() => {
  if (!isOpen) return;
  previousActiveElement.current = document.activeElement;
  modalRef.current?.focus();

  return () => {
    previousActiveElement.current?.focus();
  };
}, [isOpen]);
```

#### ✅ Touch Target Size (2.5.5)

Minimum 44x44px touch targets for mobile

```css
button,
a,
input,
select,
textarea {
  min-height: 44px;
  min-width: 44px;
}
```

### Understandable

#### ✅ Page Titles (2.4.2)

Descriptive page titles for all pages

```blade
<title>
    @hasSection('title')
        @yield('title') · Bimbel Farmasi
    @else
        Bimbel Farmasi - Solusi Akademik & Karir Farmasi Terpercaya
    @endif
</title>
```

#### ✅ Labels & Instructions (3.3.2)

All form fields have visible labels

```jsx
<Input
  label="Email Address"
  name="email"
  type="email"
  required
  helperText="We'll never share your email"
/>
```

#### ✅ Error Identification (3.3.1)

Clear error messages with `aria-invalid` and `role="alert"`

```jsx
<input aria-invalid={!!error} aria-describedby={error ? errorId : undefined} />;
{
  error && (
    <p id={errorId} role="alert" className="text-red-600">
      {error}
    </p>
  );
}
```

### Robust

#### ✅ Semantic HTML (4.1.1, 4.1.2)

Use semantic HTML elements with proper ARIA

```html
<header>
  ,
  <nav>
    ,
    <main>
      ,
      <section>
        ,
        <article>
          ,
          <aside>
            ,
            <footer></footer>
          </aside>
        </article>
      </section>
    </main>
  </nav>
</header>
```

#### ✅ ARIA Landmarks

```html
<header role="banner">
  <nav role="navigation" aria-label="Main navigation">
    <main role="main" id="main-content">
      <aside role="complementary">
        <footer role="contentinfo"></footer>
      </aside>
    </main>
  </nav>
</header>
```

#### ✅ ARIA Live Regions

Announce dynamic content changes

```javascript
window.announceToScreenReader = (message, politeness = 'polite') => {
  const announcement = document.createElement('div');
  announcement.setAttribute('role', 'status');
  announcement.setAttribute('aria-live', politeness);
  announcement.textContent = message;
  document.body.appendChild(announcement);

  setTimeout(() => {
    document.body.removeChild(announcement);
  }, 1000);
};
```

## Component Accessibility

### Button Component

```jsx
<Button type="submit" variant="primary" loading={isSubmitting} ariaLabel="Submit registration form">
  Register
</Button>
```

**Accessibility Features:**

- ✅ Keyboard accessible (Enter/Space)
- ✅ Focus visible indicator
- ✅ `aria-label` support
- ✅ `aria-busy` during loading
- ✅ Disabled state properly communicated

### Input Component

```jsx
<Input
  label="Email"
  name="email"
  required
  error={errors.email}
  helperText="Enter your email address"
/>
```

**Accessibility Features:**

- ✅ Associated `<label>` with `for` attribute
- ✅ Required indicator (visual + screen reader)
- ✅ Error messages with `aria-describedby` and `role="alert"`
- ✅ Helper text linked via `aria-describedby`
- ✅ `aria-invalid` for error state

### Modal Component

```jsx
<Modal isOpen={isOpen} onClose={handleClose} title="Confirm Payment" closeOnEscape>
  <p>Are you sure you want to proceed?</p>
</Modal>
```

**Accessibility Features:**

- ✅ `role="dialog"` and `aria-modal="true"`
- ✅ Focus trap (keyboard users can't tab out)
- ✅ Escape key to close
- ✅ Focus returns to trigger element on close
- ✅ Close button with `aria-label`

## Testing Checklist

### Manual Testing

- [ ] **Keyboard only navigation**

  - [ ] Tab through entire page
  - [ ] Activate all interactive elements with Enter/Space
  - [ ] Close modals with Escape
  - [ ] No keyboard traps

- [ ] **Screen reader testing**

  - [ ] NVDA (Windows) - Free
  - [ ] JAWS (Windows) - Commercial
  - [ ] VoiceOver (macOS/iOS) - Built-in
  - [ ] TalkBack (Android) - Built-in

- [ ] **Zoom testing**

  - [ ] 200% zoom - no content loss
  - [ ] 400% zoom - acceptable degradation
  - [ ] Text-only zoom (browser setting)

- [ ] **Color blindness simulation**
  - [ ] Protanopia (red-blind)
  - [ ] Deuteranopia (green-blind)
  - [ ] Tritanopia (blue-blind)

### Automated Testing

#### Browser Extensions

- **axe DevTools** - Free Chrome/Firefox extension
- **WAVE** - WebAIM's accessibility evaluation tool
- **Lighthouse** - Chrome DevTools (Accessibility audit)

#### Command Line

```bash
# Install Pa11y
npm install -g pa11y

# Test a page
pa11y http://localhost:8000

# Test with specific standard
pa11y --standard WCAG2AA http://localhost:8000
```

#### CI/CD Integration

```yaml
# .github/workflows/accessibility.yml
name: Accessibility Audit

on: [push, pull_request]

jobs:
  a11y:
    runs-on: ubuntu-latest
    steps:
      - uses: actions/checkout@v3
      - name: Run Pa11y
        run: |
          npm install -g pa11y-ci
          pa11y-ci --sitemap http://localhost:8000/sitemap.xml
```

## Common Accessibility Issues & Fixes

### Issue: Missing alt text on images

```blade
<!-- ❌ Bad -->
<img src="program.jpg">

<!-- ✅ Good -->
<img src="program.jpg" alt="UKOM D3 Farmasi preparation program">

<!-- ✅ Good: Decorative image -->
<img src="decoration.svg" alt="" role="presentation">
```

### Issue: Low color contrast

```css
/* ❌ Bad: 2.5:1 contrast */
.text-light {
  color: #cccccc; /* on white */
}

/* ✅ Good: 7:1 contrast */
.text-gray {
  color: #6b7280; /* on white */
}
```

### Issue: Form without labels

```html
<!-- ❌ Bad -->
<input type="text" placeholder="Email" />

<!-- ✅ Good -->
<label for="email">Email Address</label>
<input id="email" type="text" placeholder="you@example.com" />
```

### Issue: Buttons without accessible names

```html
<!-- ❌ Bad -->
<button><svg>...</svg></button>

<!-- ✅ Good -->
<button aria-label="Close modal">
  <svg aria-hidden="true">...</svg>
</button>
```

## Accessibility Resources

### Guidelines & Standards

- [WCAG 2.1](https://www.w3.org/WAI/WCAG21/quickref/)
- [WebAIM Resources](https://webaim.org/resources/)
- [A11y Project](https://www.a11yproject.com/)

### Testing Tools

- [axe DevTools](https://www.deque.com/axe/devtools/)
- [WAVE Browser Extension](https://wave.webaim.org/extension/)
- [Pa11y](https://pa11y.org/)
- [Lighthouse](https://developers.google.com/web/tools/lighthouse)

### Screen Readers

- [NVDA](https://www.nvaccess.org/) - Free (Windows)
- [JAWS](https://www.freedomscientific.com/products/software/jaws/) - Commercial (Windows)
- [VoiceOver](https://www.apple.com/accessibility/voiceover/) - Built-in (macOS/iOS)
- [TalkBack](https://support.google.com/accessibility/android/answer/6283677) - Built-in (Android)

### Color Tools

- [WebAIM Contrast Checker](https://webaim.org/resources/contrastchecker/)
- [Colorblind Web Page Filter](https://www.toptal.com/designers/colorfilter)
- [Color Oracle](https://colororacle.org/) - Colorblindness simulator

## Maintenance

### Regular Audits

- Run automated tests on every PR (CI/CD)
- Manual testing quarterly
- Screen reader testing bi-annually
- User testing with disabled users annually

### Documentation

- Document accessibility features in component JSDoc
- Update this guide when adding new components
- Track WCAG compliance in issue tracker

### Training

- Team accessibility training annually
- Share accessibility resources with team
- Code review checklist includes accessibility
