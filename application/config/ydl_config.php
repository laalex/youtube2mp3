<?php
/*=================================
 == YoutubeDL Helper config file ==
 ================================*/
 //Executables folder, file names
 $config['exec_folder'] = 'exec';
 $config['ydl_exe'] = 'youtube-dl.exe';
 $config['ffmpeg_exe'] = 'ffmpeg.exe';
 //Absolute paths to the files
 $config['exepath'] = realpath(dirname(dirname(__FILE__))).DIRECTORY_SEPARATOR.$config['exec_folder'].DIRECTORY_SEPARATOR.$config['ydl_exe'];
 $config['ffmpegpath'] = realpath(dirname(dirname(__FILE__))).DIRECTORY_SEPARATOR.$config['exec_folder'].DIRECTORY_SEPARATOR.$config['ffmpeg_exe'];