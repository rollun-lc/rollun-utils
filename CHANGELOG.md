# CHANGELOG.md

## 9.0.1

- Fixed Independence Day in `rollun\utils\DateTime\WorkingDays` to follow USPS: a Saturday July 4 is no longer
  moved to Friday (post offices stay open on Friday and close on Saturday), a Sunday July 4 is still observed on
  Monday. Other holidays keep the federal Saturday-to-Friday rule.

## 9.0.0

- Removed `rollun\Downloader` as it wasn't used anywhere and required the abandoned `nicolab/php-ftp-client` package
- Removed `rollun\utils\Cleaner` as it wasn't used anywhere and required the `opis/closure` package
- Removed `rollun\utils\Php\Serializer` as we didn't need it and it required the `opis/closure` package
- Removed `rollun-com/rollun-installer` and all its related components.
- Removed `rollun\tracer` and `rollun\utils\TelegramClient`  as we didn't need them, and they required
  the `laminas/laminas-http` package