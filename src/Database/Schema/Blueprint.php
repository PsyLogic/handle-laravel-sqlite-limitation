<?php

namespace Psylogic\SQLite\Database\Schema;

use BadMethodCallException;
use Illuminate\Database\Schema\Blueprint as BaseBlueprint;
use Illuminate\Database\Connection;
use Illuminate\Support\Fluent;
use Psylogic\SQLite\Database\SQLiteConnection;

class Blueprint extends BaseBlueprint
{

    /**
     * Ensure the commands on the blueprint are valid for the connection type.
     *
     * @param  \Illuminate\Database\Connection  $connection
     * @return void
     *
     * @throws \BadMethodCallException
     */

    protected function ensureCommandsAreValid(Connection $connection)
    {
        if ($connection instanceof SQLiteConnection) {
            if ($this->commandsNamed(['dropColumn'])->count() > 1) {
                // Fix Drop multiple separeted columns
                // Convert
                // $this->dropColum('column1')
                // $this->dropColum('column2')
                // To =>  $this->dropColum(['column1','column2'])
                $arrayColumns = [];
                foreach ($this->commands as $key => $command) {
                    if ($command->name == 'dropColumn') {
                        $arrayColumns[] = $command->columns;
                        unset($this->commands[$key]);
                    }
                }
                $this->dropColumn(collect($arrayColumns)->flatten()->toArray());
            }

            if ($this->commandsNamed(['renameColumn'])->count() > 1) {
                throw new BadMethodCallException(
                    "SQLite doesn't support multiple calls to renameColumn in a single modification."
                );
            }

            // Ignore Droping foreign key
            if ($this->commandsNamed(['dropForeign'])->count() > 0) {
                return new Fluent();
            }

            // Fix Cannot add a NOT NULL column with default value NULL
            if (!$this->creating()) {
                foreach ($this->columns as $key => $column) {
                    if (!isset($column['change'])) {
                        if (!isset($column['nullable'])) {
                            $this->columns[$key]['nullable'] = true;
                        }
                    }
                }
            }
        }
    }
}
