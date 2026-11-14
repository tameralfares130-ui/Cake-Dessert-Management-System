# Test results

On 14 November 2026 the amended project passed **20 tests and 131 assertions** locally using PHP 8.4.27, Laravel 12.71.0 and PHPUnit 11.5.57. The database was SQLite in memory, as configured in `phpunit.xml`; production MySQL was not contacted. The test command was `php artisan test --no-ansi`. Composer installed the existing lock file without dependency changes.

| Suite | Tests | Coverage |
|---|---:|---|
| WebsiteTest | 6 | Public routes, guest restrictions, registration role protection, admin creation, contact validation and storage |
| AccessAndCrudTest | 5 | Login/logout, rejected credentials, non-admin write denial, read/update/delete, cascades, invalid CRUD input, role-aware navigation |
| DatabaseBrowseTest | 4 | Combined search/type filters, related values, pagination, empty results, malformed or oversized input |
| GraphTest | 2 | Aggregated counts, accessible tables, unspecified units, empty datasets |
| MessagesTest | 2 | Newest-first ordering, timestamps, escaped output, rejection without persistence |
| SeedDataTest | 1 | Two seeding passes, source counts, relationships and graph totals |

The final run completed in 2.29 seconds, with no test warnings. An earlier run warned because the local `.env` file had not yet been copied; copying `.env.example` as documented resolved the warnings. `composer validate --no-check-publish` passed with an advisory that no license was specified. No license was invented for the team.

## Limits

These are Laravel HTTP/feature tests, not browser automation or a complete security audit. Laravel's test environment normally bypasses CSRF middleware, so these tests do not establish live CSRF behaviour. They do not verify production MySQL, hosting configuration, mobile layout, actual screen-reader behaviour or JavaScript chart rendering. The CI workflow is provided, but its status must be read from the actual GitHub run before claiming CI passed.

The 14 November browser review observed the live homepage, a database listing reporting 139 products, and the graph page. It did not authenticate, send contact messages or modify production data. The live graph lacked PR #4's summary totals; deployment parity remains to be checked. This branch has not been deployed by the review process.

The additional tests do not, by themselves, fulfil the optional five-point Test menu task, which also requires a separate form application and comparable unit/feature tests.
