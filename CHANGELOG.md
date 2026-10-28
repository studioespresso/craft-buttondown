# Release Notes for Buttondown

## 1.1.1 - 2026-10-28
### Fixed
- Subscribing without custom fields failed with a 422 from Buttondown, because empty `metadata` was sent as a list instead of an object

## 1.1.0 - 2026-10-28
### Added
- The API key can now be set per site in `config/buttondown.php`, so each site can subscribe to its own newsletter
- Use Buttondown's current API domain, `api.buttondown.com`

## 1.0.0
- Initial release
