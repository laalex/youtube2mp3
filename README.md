## ZONGLIST web application

`Version 1.0`

Application works on _linux_ environment (tested on `ubuntu 12.04LTS server`). Requires the following things on the server in order to run:

1. youtube-dl
2. ffmpeg



## Current features:

1. Playlists
2. Listen to songs
3. Download a song
4. Download entire playlist
5. Listen to a playlist
6. Share a playlist
7. Custom MP3 player
8. Androi mobile application compatible with > 4.1.1 Android
9. Search directly on YouTube to download a song
10. Continous playlist listening


## Known bugs and issues

1. Songs cannot be removed
2. PlayList pages are updated every `5` seconds by polling the server.
3. Songs are being downloaded even if the ID is not unique
4. PlayList don't automatically load songs when they are expired
5. Application state inflicts an error to the REPEAT and causes the player to automatically repeat.

## Upcoming features

1. Keyboard shortcuts for MP3 player
2. Automix feature
3. Song crop (should allow the user to queue different timestamps for start and stop)


### Changelog
`V 1.0`

* Fixed 12 bugs uppon release
* Added Playlists
* Added playlist change within the playlist view controller
* Added playlost repeat, one repeat, repeat none to the MP3 player
* Improved MP3 player response 
* Improved UX/UI
