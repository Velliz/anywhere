# AGENTS.md

This file applies to the entire repository.

## Project Summary

- `Anywhere` is a PHP-based Output-as-a-Service application built on top of the Puko framework.
- The UI use Bootstrap CSS library version 3.
- The app renders outputs from HTML/CSS templates and JSON data, with features like PDF generation, spreadsheets, email, QR codes, and digital signing.
- Primary runtime requirements are PHP 7.3+, Composer dependencies, MySQL/MariaDB, and Node tooling used for frontend/watch workflows.

## Repository Layout

- `controller/` contains request handlers, including `controller/api/` and `controller/primary/`.
- `model/` and `plugins/model/` contain data access and domain logic.
- `plugins/` holds framework extensions and shared application modules.
- `config/` contains local environment configuration such as app, database, and encryption settings.
- `assets/` contains frontend resources, templates, tutorials, and vendor bundles.
- `bootstrap/` contains framework/bootstrap wiring.
- `storage/` holds generated runtime artifacts such as fonts and temporary files.
- `tests/unit/` is the existing test location.

## Working Rules

- Keep changes minimal and localized; follow existing naming and structure.
- Do not commit generated files from `storage/` or dependency directories.
- Treat `assets/vendor/` as third-party code; avoid editing it unless the task explicitly requires a vendor patch.
- Prefer fixing behavior in app code (`controller/`, `model/`, `plugins/`, `config/`) rather than patching generated assets.
- Preserve PHP 7.3 compatibility unless the user explicitly asks for a version upgrade.

## Setup And Validation

- Install backend dependencies with `composer install`.
- Install frontend dependencies with `npm install`.
- Generate the database scaffolding with `php puko generate db`.
- Start the local app with `php puko serve 4000`.
- Use `npm run watch` only when frontend asset watching is needed.
- There is no meaningful default `npm test`; verify changes with targeted checks or app-specific tests instead.

## Configuration Notes

- Local machine settings usually require updates in `config/app.php`, `config/database.php`, and `config/encryption.php`.
- Avoid committing machine-specific secrets or environment-specific credentials.

## Editing Guidance

- If a task touches a specific subtree with extra conventions, add a more local `AGENTS.md` there instead of overloading this root file.
- Read large files in chunks when inspecting them.
- When changing behavior, update docs only if the public workflow or developer setup changes.
