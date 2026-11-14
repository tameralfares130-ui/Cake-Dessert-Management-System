# Shahriar Mir Munem contribution report

Student: Shahriar Mir Munem. Neptun: C2TB9P. GitHub: `evanshahriar555-spec`.

## Scope

The original history through `04266771ad30d88841cc3d1351dd1f84c23e77fa` contains no commits attributed to this account. The work described here is new work prepared on `shahriar/validation-tests-submission` with Codex assistance, at Shahriar's request. It does not reattribute Tamer's earlier work or represent unaided authorship. Shahriar should review and be able to explain the implementation before submission, following the course's rules on assistance.

## Implementation

Database browsing now validates search/type as bounded strings and the page number as a positive integer before constructing the Eloquent query. This rejects array-shaped or oversized query values instead of passing them to query construction. The existing search and category filtering behaviour is preserved. A browser input length limit complements server validation.

The graph view now includes semantic tables with the same grouped counts used by Chart.js. Tables remain usable if the chart library is unavailable. Empty datasets have explicit messages, and blank price units display as Unspecified. This improves access to the data without changing the underlying totals.

The homepage no longer advertises recipes, which the application does not implement, and labels its count as the current catalogue count. The shared footer uses the supplied uppercase Neptun code C2TB9P.

Five additional test classes cover access and CRUD behaviour, browsing, charts, messages and repeatable seeding. A GitHub Actions workflow runs the suite on pull requests and main changes. Documentation distinguishes source evidence, local test results and outstanding live verification; the README reflects the PHP minimum required by the committed lock file.

## Verification and remaining work

The complete local suite passed 20 tests and 131 assertions using PHP 8.4.27 and SQLite in memory. See `TEST_RESULTS.md`. These results do not prove deployment or completion of the professor's Authentication-starter requirement. The final report still needs actual hosted evidence, starter comparison, published contribution links and private access details.
