<?php

namespace FerdinandFrank\LaravelFileGenerator;

/**
 * MigrationCreator
 * -----------------------
 * Class to create migration files based on the 'MigrateMakeCommand'.
 *
 * @author Ferdinand Frank
 */
class MigrationCreator extends \Illuminate\Database\Migrations\MigrationCreator {

    /**
     * Gets the migration stub file.
     *
     * @param  string $table
     * @param  bool   $create
     *
     * @return string
     */
    protected function getStub($table, $create) {
        if (is_null($table)) {
            return $this->files->get(StubHelper::find('/migration.blank.stub'));
        }

        // We also have stubs for creating new tables and modifying existing tables
        // to save the developer some typing when they are creating a new tables
        // or modifying existing tables. We'll grab the appropriate stub here.
        else {
            $stub = $create ? 'migration.create.stub' : 'migration.update.stub';

            return $this->files->get(StubHelper::find("/$stub"));
        }
    }
}