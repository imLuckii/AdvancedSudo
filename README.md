[![](https://poggit.pmmp.io/shield.dl/AdvancedSudo)](https://poggit.pmmp.io/p/AdvancedSudo)
[![](https://poggit.pmmp.io/shield.dl.total/AdvancedSudo)](https://poggit.pmmp.io/p/AdvancedSudo)
# AdvancedSudo

AdvancedSudo is a Minecraft plugin that introduces commands allowing server administrators to send messages as other players or to all online players.

## Commands

- **/sudo**
  - Usage: `/sudo <player> <message>`
  - Description: Send messages as another player.

- **/sudoall**
  - Usage: `/sudoall <message>`
  - Description: Send messages as all online players.

## Permissions

- `sudo.command`
  - Default: op
  - Description: Allows players to use the `/sudo` command.

- `sudoall.command`
  - Default: op
  - Description: Allows players to use the `/sudoall` command.

## Configuration

```yaml
# Config Version
# DO NOT CHANGE THIS
config-version: "1.0"

# If enabled, when you use the "/sudo" command, you can type part of a username
# (at least the specified minimum number of characters), and it will return the matching player.
partial_username: true

# The minimum number of characters required for partial username matching.
# This value is used when partial_username is set to true.
# Example: If set to 2, typing '/sudo Ni' can match 'NightDevil9440'.
partial-username-min: 2

# List of player names that are blacklisted from being sudoed using /sudo or /sudoall commands.
# Separate each player name with a comma.
# Example:
# blacklist: NightDevil9440, BoxierChimera37
blacklist: NightDevil9440, BoxierChimera37
```

## Issue Reporting

If you encounter any bugs or glitches, please create an issue [here](https://github.com/imLuckii/AdvancedSudo/issues/new).

## Suggestions

Any suggestions you may have to improve AdvancedSudo are welcome. Feel free to create an issue [here](https://github.com/imLuckii/AdvancedSudo/issues/new).

## Contribution

If you want to contribute to this project, create a pull request [here](https://github.com/imLuckii/AdvancedSudo/pulls).
