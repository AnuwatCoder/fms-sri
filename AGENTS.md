# AI Development Guide

This file defines the rules for AI-assisted changes in this repository. It applies to the entire project unless a more specific `AGENTS.md` exists in a subdirectory.

## Project context

- Laravel 13, PHP 8.3+, Livewire 4, Bootstrap 5, Vite, and Pest 4.
- The application is an information portal for the Strategic Work, Revenue Management and Information Innovation Division.
- Public content is primarily Thai. Use English for class names, methods, variables, and other code identifiers.
- The public portal contains systems, news, documents, events, division information, personnel, and contact pages.
- The administration area is under `/admin` and is protected by the `auth` and `admin` middleware.

## Non-negotiable behavior

- Preserve existing routes, route names, authentication, admin authorization, database behavior, and public URLs unless the task explicitly requests a change.
- Keep current business rules, especially the single personnel head rule and head-first display order.
- Do not expose inactive or future-dated content where existing published scopes exclude it.
- Do not remove file cleanup behavior when replacing or deleting uploaded media.
- Do not weaken rich-text sanitization, upload validation, or admin middleware.
- Do not modify unrelated user changes in the working tree.

## Laravel structure

- Keep controllers thin. They should coordinate requests, models, services, and responses.
- Put validation and request normalization in Form Requests under `app/Http/Requests`.
- Use Eloquent directly for straightforward CRUD and queries. Do not introduce repositories unless they solve a demonstrated problem.
- Put multi-step business operations, transactions, and uploaded-file lifecycle logic in focused services under `app/Services`.
- Put finite domain values and their labels/icons in backed enums under `app/Enums`.
- Keep reusable query logic in named Eloquent scopes.
- Keep small stateless formatting or sanitizing helpers under `app/Support`.
- Add Resources, Jobs, Events, Listeners, or Policies only when the requested behavior genuinely needs them. Do not create empty architectural layers.
- Prefer dependency injection over facades inside services when a service dependency already exists.

## Database and seed data

- This project is currently in development. Until the first production release, fold new columns into the relevant original `create_*` migration instead of adding incremental `add_*` migrations.
- Keep separate create migrations for distinct domains when that improves clarity.
- Never run `migrate:fresh`, destructive SQL, or any command that deletes local data without explicit user approval.
- Do not change the schema unless the requested feature requires it.
- Seeders must be idempotent. Prefer stable natural keys with `updateOrCreate` or `firstOrCreate` as appropriate.
- Keep reusable sample records in `database/seeders/Data` and orchestration in dedicated Seeder classes.
- Use dates relative to the seeding date for sample news and future events when fixed dates would become stale.
- Bundled sample media belongs under `public/images`; uploaded media belongs on the `public` filesystem disk.
- Seed data must remain realistic, clearly non-sensitive, and safe to show in development.

## Frontend conventions

- Reuse the existing Blade components, Livewire components, Bootstrap utilities, and CSS patterns before creating new abstractions.
- Use the locally installed Anuphan font. Do not add a remote font or CDN dependency.
- Public page wrappers use `container-fluid` and must remain responsive.
- Keep admin and public visual styles separated by their existing class prefixes and layouts.
- Preserve Thai labels and terminology already used by the interface.
- Include accessible labels, meaningful button text, keyboard-friendly controls, and sensible image alternatives.
- Provide an initials fallback when a personnel photo is unavailable.
- Avoid inline JavaScript and inline styling unless the existing component specifically uses a CSS custom property for dynamic content.
- Do not edit generated files in `public/build`; update source files and run Vite instead.

## Media handling

- Validate image type and size through a Form Request.
- Store user uploads through `PublicFileStorage` or the existing domain service.
- Delete replaced and deleted uploads, but never delete bundled files under `public/images`.
- Models that support both bundled and uploaded media must resolve both `images/...` and public-disk paths.
- Keep the `public/storage` link requirement in mind when diagnosing missing uploaded files.

## Code style

- Follow the conventions already present in neighboring files and Laravel defaults.
- Use strict, descriptive method and variable names; avoid abbreviations that obscure intent.
- Add return types and useful array-shape or generic PHPDoc where PHP cannot express the type.
- Prefer early returns and small focused methods over deeply nested code.
- Avoid duplicated validation, query, formatting, and file-management logic.
- Do not add comments that merely restate the code. Comment only non-obvious decisions or constraints.
- Run Laravel Pint after editing PHP files.

## Testing requirements

- Add or update Pest feature tests for behavior changes and regressions.
- Tests must cover authorization, validation, database effects, and file lifecycle when relevant.
- Seeder changes must verify representative data and idempotency.
- Use `Storage::fake('public')` and uploaded-file fakes for media tests.
- Do not weaken or delete a meaningful test to make a change pass.
- Before finishing, run the checks relevant to the change. For a normal full verification use:

```bash
php artisan test
vendor/bin/pint --test
npm run build
```

- Also run `git diff --check` and review the final diff for unintended changes.
- A pre-existing, understood warning may be reported, but new warnings or failures must be resolved before handoff.

## Working process

1. Inspect the related routes, request, controller/component, model, service, view, migration, seeder, and tests before editing.
2. Make the smallest coherent change that satisfies the request.
3. Preserve existing behavior outside the requested scope.
4. Format and test in proportion to the change.
5. Report the outcome, important files changed, checks run, and any remaining issue concisely.

## Avoid

- Repository patterns without demonstrated value.
- Business logic in Blade templates or Form Requests.
- Validation arrays duplicated inside controllers.
- Direct file deletion scattered across controllers.
- Hard-coded production credentials, private personal data, or secrets in seeders.
- New dependencies when the framework or an existing package already provides the needed capability.
- Large unrelated refactors during a focused feature request.
