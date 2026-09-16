# Changelog

## 3.1.0 - 2026-09-16

- fix single-value allowlist parenthesization by @SanderMuller in #78
- bump `actions/checkout` from 6 to 7
- bump `actions/cache` from 5 to 6

## 3.0.0 - 2026-08-18

- drop support for PHP 8.1
- add support for PHP 8.5
- drop support for Laravel < 12
- add support for Laravel 13
- narrow `orchestra/testbench` to `^10.0|^11.0`

## 2.4.0 - 2026-04-13

- Laravel 13 compatibility
- bump `actions/cache` from 4 to 5

## 2.3.2 - 2026-01-06

- fix `report-to` directive (thanks @Lucasmeteenc)

## 2.3.1 - 2025-06-17

- bump `stefanzweifel/git-auto-commit-action` from 5 to 6

## 2.3.0 - 2025-02-17

- Laravel 12 compatibility
- add FLOC to default directives, set its rule to `none`
- add code of conduct
- clean up PHPUnit configuration

## 2.2.0 - 2024-03-06

- fix a bug reported in #55
- update `driftingly/rector-laravel` requirement range

## 2.1.0 - 2023-05-02

- update standardised permission policies by @Treggats in #26
- introduced proposed permission policies by @Treggats in #27
- PHPUnit upgrade to version 10 by @Treggats in #22
- templates for new issues and bug reports
- a lot of under the hood changes

## 2.0.0 - 2023-03-22

- add Github Action workflows for testing and code quality
  * PHPStan
  * PHP CS Fixer
- replace PHPCS with PHP CS Fixer
- drop support for PHP < 7.4
- add support for PHP 7.4 - 8.2
- drop support for Laravel < 7.0
- add support for Laravel 7.x - 10.x
- update PHPUnit configuration

## 1.3.0 - 2022-01-31

- add support for PHP 8.1
- add support for Laravel 9

## 1.2.0 - 2021-10-25

- implemented [RFC-8941](https://datatracker.ietf.org/doc/html/rfc8941) Structured Field Values for directive values

## 1.1.2 - 2021-01-02

- add PHP 8 support

## 1.0.9 - 2019-09-14

- fix array and string helpers missing from Laravel's core

## 1.0.8 - 2019-08-27

- add missing directive

## 1.0.7 - 2019-08-27

- get the package ready for Laravel 6.0

## 1.0.1 - 2018-08-28

- fixed Laravel package autodiscover in composer.json

## 1.0.0 - 2018-08-28

- initial release
