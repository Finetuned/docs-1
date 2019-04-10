`Gitify build`

Used to read the data files, and write them to the MODX database. Note that this reads the `.gitify` file to see what needs to be built; it doesn't blindly try to write any file it encounters.  

As of v0.9, `Gitify build` automatically cleans up any orphaned objects it encounters. An orphaned object is an object that exists in the database, but not in the gitify files. This works on both resources and other objects. To disable orphan handling, include the `--no-cleanup` flag. Before v0.9, you had to use the `--force` attribute to ensure the database matched the files exactly. 

Also as of v0.9, `Gitify build` automatically tries to resolve duplicate id/primary key conflicts for both content and other objects. Whenever it finds an object of which the real primary key (typically the ID) already exists, it will temporarily keep that object in memory. After completing the rest of the build, including the orphans clean up, it will attempt to resolve the conflict. In the case of a moved or renamed object/resource, the orphan clean up will have removed the "old" object by then, in which case the object will be inserted normally. If there is a genuine conflict (perhaps two developers added a new resource or object in separate branches), it will insert the object with a new auto incremented ID. It will also execute a `Gitify extract` in that case. 

````
Usage:
 build [--skip-clear-cache] [-f|--force] [--no-backup] [--no-cleanup]

Options:
 --skip-clear-cache    When specified, it will skip clearing the cache after building.
 --force (-f)          When specified, all existing content will be removed before rebuilding. Can be useful when having dealt with complex conflicts.
 --no-backup           When using the --force attribute, Gitify will automatically create a full database backup first. Specify --no-backup to skip creating the backup, at your own risk.
 --no-cleanup          With --no-cleanup specified the built-in orphan handling is disabled for this build. The orphan handling removes objects that no longer exist in files from the database.
 --help (-h)           Display this help message.
 --verbose (-v|vv|vvv) Increase the verbosity of messages: 1 for normal output, 2 for more verbose output and 3 for debug.
 --version (-V)        Display the Gitify version.
````
