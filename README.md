# OpList

OpList displays a paginated list of server operators, including each operator's online or offline status. Players can use `/oplist` or `/ops`.

## Requirements and compatibility

- Axolotl-PM API 5.0.0, as declared in [`plugin.yml`](plugin.yml). PHPStan at maximum level passes against the 5.0.0 and 5.49.1 source revisions. Intermediate releases have not been tested.
- PHP 8.1 or newer, as required by those Axolotl-PM source revisions.
- No external plugin or runtime library dependency.

A PHAR built from this source has been checked for startup and console command output on Axolotl-PM 5.49.1. Online status with connected Bedrock clients still needs a live check.

## Installation

Download the PHAR from [GitHub Releases](https://github.com/NhanAZ-Plugins/OpList/releases), place it in the server's `plugins` directory, and restart Axolotl-PM.

## Command and permission

```text
/oplist [page]
/ops [page]
```

The optional page is a positive whole number. The `oplist.command` permission is enabled for all players by default. The command also works from the server console.

## Configuration

[`resources/config.yml`](resources/config.yml) defines the page size and messages. The file is copied to the plugin data directory on first startup. `perPage` must be a positive integer; the seven message values must be strings. Invalid settings produce a server log error and prevent the command from listing operators until the configuration is fixed and the server restarts. Set `endPage` to an empty string to hide the last line.

The placeholders `{page}`, `{maxPage}`, `{totalOpsOnline}`, `{numericalOrder}`, `{opName}` and `{onlineStatus}` can be used in the relevant message templates. Online status matches complete player names, so one operator's name cannot accidentally match another player's prefix.

## Build and verification

The [build workflow](.github/workflows/build.yml) tests pagination and runs PHPStan at maximum level. It uses [DevTools](https://github.com/NhanAZ/DevTools) to build and inspect a downloadable PHAR. The workflow pins DevTools and Axolotl-PM source to reviewed commits. Run local pagination cases with `php tests/pagination.php`.

For a local build, follow the [DevTools CLI guide](https://github.com/NhanAZ/DevTools/blob/main/docs/cli.md) with this repository as the project directory. PHAR inspection and console output do not verify status rendering for connected clients.

## Support and license

Report bugs in [GitHub Issues](https://github.com/NhanAZ-Plugins/OpList/issues) or contact [NhanAZ Discord](https://discord.gg/j2X83ujT6c). OpList retains its existing [GPL-3.0 license](LICENSE).
