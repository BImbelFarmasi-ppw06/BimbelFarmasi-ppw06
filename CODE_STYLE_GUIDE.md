# Code Style and Quality Guide

## Overview

This document outlines the code style conventions and quality standards for the Bimbel Farmasi project.

## Automated Code Formatting

### PHP CS Fixer

**Installation:**

```bash
composer require --dev friendsofphp/php-cs-fixer
```

**Configuration:** `.php-cs-fixer.php`

- PSR-12 compliance
- PHP 8.2 migration rules
- Laravel-specific rules
- Custom project preferences

**Usage:**

```bash
# Check code style issues
vendor/bin/php-cs-fixer fix --dry-run --diff

# Fix code style issues
vendor/bin/php-cs-fixer fix

# Fix specific directory
vendor/bin/php-cs-fixer fix app/Http/Controllers
```

**CI Integration (already in `.github/workflows/ci.yml`):**

```yaml
- name: Check code style
  run: vendor/bin/pint --test
```

### Prettier (JavaScript/CSS/JSON)

**Installation:**

```bash
npm install --save-dev prettier
```

**Configuration:** `.prettierrc`

- Single quotes for JavaScript
- 2 spaces for JS/JSON/YAML
- Trailing commas in ES5
- Print width: 100 characters

**Usage:**

```bash
# Check formatting
npm run prettier:check

# Fix formatting
npm run prettier:write
```

**Add to `package.json`:**

```json
{
  "scripts": {
    "prettier:check": "prettier --check 'resources/**/*.{js,jsx,css,json}'",
    "prettier:write": "prettier --write 'resources/**/*.{js,jsx,css,json}'"
  }
}
```

### EditorConfig

**File:** `.editorconfig`

Ensures consistent coding styles across different editors and IDEs:

- UTF-8 encoding
- LF line endings
- 4 spaces for PHP/Blade
- 2 spaces for JS/CSS/JSON/YAML
- Trim trailing whitespace
- Final newline

**Supported Editors:**

- VS Code (install EditorConfig extension)
- PhpStorm (built-in support)
- Sublime Text (install EditorConfig plugin)
- Atom (install editorconfig package)

## PHP Code Style

### Naming Conventions

```php
// Classes: PascalCase
class OrderController extends Controller {}

// Methods/Functions: camelCase
public function processPayment() {}

// Variables: camelCase
$orderTotal = 1000;

// Constants: SCREAMING_SNAKE_CASE
const MAX_RETRY_ATTEMPTS = 3;

// Database tables: snake_case (plural)
Schema::create('order_items', function (Blueprint $table) {});

// Database columns: snake_case
$table->string('payment_method');
```

### Method Order in Classes

```php
class ExampleController extends Controller
{
    // 1. Traits
    use AuthorizesRequests;

    // 2. Constants
    const MAX_ITEMS = 100;

    // 3. Properties (public → protected → private)
    public $publicProperty;
    protected $protectedProperty;
    private $privateProperty;

    // 4. Constructor
    public function __construct() {}

    // 5. Public methods
    public function index() {}
    public function store() {}

    // 6. Protected methods
    protected function validateInput() {}

    // 7. Private methods
    private function calculateTotal() {}
}
```

### DocBlocks

```php
/**
 * Process payment for an order
 *
 * @param Order $order The order to process payment for
 * @param string $paymentMethod Payment method (e.g., 'midtrans', 'manual')
 * @return Payment The created payment record
 * @throws PaymentException If payment processing fails
 */
public function processPayment(Order $order, string $paymentMethod): Payment
{
    // Method implementation
}
```

### Array Syntax

```php
// ✅ Use short array syntax
$items = ['apple', 'banana', 'orange'];

// ❌ Avoid old array syntax
$items = array('apple', 'banana', 'orange');

// ✅ Multi-line arrays
$config = [
    'driver' => 'mysql',
    'host' => 'localhost',
    'port' => 3306,
];
```

### String Concatenation

```php
// ✅ Use single space around concatenation operator
$message = 'Hello, ' . $name . '!';

// ✅ For complex strings, use interpolation
$message = "Hello, {$user->name}! Your order #{$order->id} is ready.";
```

### Control Structures

```php
// ✅ Always use braces
if ($condition) {
    doSomething();
}

// ❌ Avoid omitting braces
if ($condition)
    doSomething();

// ✅ Early returns
public function update(Order $order)
{
    if (! auth()->check()) {
        return redirect()->route('login');
    }

    if ($order->status === 'completed') {
        return back()->with('error', 'Cannot update completed order');
    }

    // Main logic here
}
```

## JavaScript/React Code Style

### Component Structure

```jsx
// ✅ Functional components with named exports
export default function OrderForm({ order, onSubmit }) {
  const [isSubmitting, setIsSubmitting] = useState(false);

  const handleSubmit = async (e) => {
    e.preventDefault();
    setIsSubmitting(true);
    await onSubmit();
    setIsSubmitting(false);
  };

  return <form onSubmit={handleSubmit}>{/* Component JSX */}</form>;
}
```

### Naming Conventions

```javascript
// Components: PascalCase
const OrderForm = () => {};

// Functions/Variables: camelCase
const handleSubmit = () => {};
const orderTotal = 1000;

// Constants: SCREAMING_SNAKE_CASE
const API_BASE_URL = 'https://api.example.com';

// Props: camelCase
<Button onClick={handleClick} isLoading={true} />;

// Event handlers: handle[Event]
const handleClick = () => {};
const handleSubmit = () => {};
```

### Destructuring

```javascript
// ✅ Destructure props
export default function OrderCard({ order, user, onDelete }) {
  // ...
}

// ✅ Destructure state
const { items, total, discount } = order;
```

### Conditional Rendering

```jsx
// ✅ Use && for simple conditions
{
  isLoading && <Spinner />;
}

// ✅ Use ternary for if/else
{
  user ? <UserMenu /> : <LoginButton />;
}

// ❌ Avoid nested ternaries
{
  user ? admin ? <AdminPanel /> : <UserPanel /> : <Login />;
}

// ✅ Extract to variable/function
const Panel = user ? (admin ? AdminPanel : UserPanel) : Login;
<Panel />;
```

## Blade Template Style

### Directives

```blade
{{-- ✅ Use Blade directives over PHP tags --}}
@if ($order->isPaid())
    <span class="badge badge-success">Paid</span>
@else
    <span class="badge badge-warning">Pending</span>
@endif

{{-- ❌ Avoid PHP tags in Blade --}}
<?php if ($order->isPaid()): ?>
    <span>Paid</span>
<?php endif; ?>
```

### Escaping

```blade
{{-- ✅ Automatic escaping for user input --}}
<h1>{{ $user->name }}</h1>

{{-- ✅ Unescaped for trusted HTML --}}
<div>{!! $article->content !!}</div>

{{-- ❌ Never use unescaped for user input --}}
<div>{!! $request->input('comment') !!}</div>
```

### Component Usage

```blade
{{-- ✅ Use Blade components for reusability --}}
<x-button variant="primary" size="lg">
    Submit Order
</x-button>

<x-alert type="success" dismissible>
    Order created successfully!
</x-alert>
```

## Database Conventions

### Migration Files

```php
// ✅ Descriptive migration names
2024_01_01_000000_create_orders_table.php
2024_01_02_000000_add_payment_method_to_payments_table.php

// ✅ Proper table structure
Schema::create('orders', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained()->onDelete('cascade');
    $table->string('order_number')->unique();
    $table->decimal('amount', 10, 2);
    $table->enum('status', ['pending', 'processing', 'completed', 'cancelled']);
    $table->timestamps();
    $table->softDeletes();
});
```

### Eloquent Models

```php
// ✅ Use protected properties
protected $fillable = ['name', 'email', 'amount'];
protected $guarded = ['id', 'created_at', 'updated_at'];

// ✅ Define relationships with type hints
public function orders(): HasMany
{
    return $this->hasMany(Order::class);
}

// ✅ Use accessors/mutators
public function getFullNameAttribute(): string
{
    return "{$this->first_name} {$this->last_name}";
}
```

## Git Commit Messages

### Format

```
type(scope): subject

body (optional)

footer (optional)
```

### Types

- `feat`: New feature
- `fix`: Bug fix
- `docs`: Documentation only
- `style`: Code style changes (formatting, no logic change)
- `refactor`: Code refactoring
- `test`: Adding/updating tests
- `chore`: Maintenance tasks

### Examples

```bash
# Good commit messages
feat(payment): add Midtrans payment integration
fix(order): prevent duplicate order submissions
docs(readme): update deployment instructions
test(payment): add unit tests for payment processing

# Bad commit messages
update
fix bug
changes
wip
```

## Code Review Checklist

### Functionality

- [ ] Code works as expected
- [ ] Edge cases are handled
- [ ] Error handling is implemented
- [ ] No breaking changes

### Code Quality

- [ ] Follows coding standards
- [ ] No code duplication
- [ ] Proper naming conventions
- [ ] Adequate comments/documentation

### Security

- [ ] Input validation implemented
- [ ] SQL injection prevention
- [ ] XSS prevention
- [ ] CSRF protection

### Performance

- [ ] No N+1 queries
- [ ] Appropriate caching
- [ ] Efficient algorithms
- [ ] Database indexes used

### Testing

- [ ] Unit tests added/updated
- [ ] Feature tests added/updated
- [ ] Tests passing
- [ ] Code coverage maintained

### Accessibility

- [ ] Keyboard navigation works
- [ ] ARIA labels added
- [ ] Color contrast meets WCAG AA
- [ ] Alt text for images

## IDE Configuration

### VS Code

**Recommended Extensions:**

- PHP Intelephense
- Laravel Extra Intellisense
- Blade Formatter
- ESLint
- Prettier
- EditorConfig

**Settings (`.vscode/settings.json`):**

```json
{
  "editor.formatOnSave": true,
  "editor.codeActionsOnSave": {
    "source.fixAll.eslint": true
  },
  "[php]": {
    "editor.defaultFormatter": "junstyle.php-cs-fixer"
  },
  "[javascript]": {
    "editor.defaultFormatter": "esbenp.prettier-vscode"
  }
}
```

### PhpStorm

**Settings:**

- Enable EditorConfig support
- Set PHP CS Fixer as code formatter
- Enable Prettier for JavaScript/CSS
- Configure code style: Settings → Editor → Code Style → PHP → Set from... → PSR-12

## References

- [PSR-12: Extended Coding Style](https://www.php-fig.org/psr/psr-12/)
- [Laravel Best Practices](https://github.com/alexeymezenin/laravel-best-practices)
- [Airbnb JavaScript Style Guide](https://github.com/airbnb/javascript)
- [React Best Practices](https://react.dev/learn)
