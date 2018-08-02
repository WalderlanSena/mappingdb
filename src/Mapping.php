<?php

namespace App;

class Mapping
{
	private $server;
    private $args;

	public function __construct($server)
	{
		$this->server = $server;
		$this->args   = $this->server['argv'];
	}

	public function verifyArguments() : void
	{
		if ($this->server["argc"] < 3) {
		    $this->splash();
			fwrite(STDOUT, PHP_EOL."usage: php map.phar [NAMESPACE] [NAME FILE]".PHP_EOL);
			exit(1);
		}
	}

	private function splash() : void
    {
        $splash = "\033[32m
         __  __                   _             ____  ____  
        |  \/  | __ _ _ __  _ __ (_)_ __   __ _|  _ \| __ ) 
        | |\/| |/ _` | '_ \| '_ \| | '_ \ / _` | | | |  _ \ 
        | |  | | (_| | |_) | |_) | | | | | (_| | |_| | |_) |
        |_|  |_|\__,_| .__/| .__/|_|_| |_|\__, |____/|____/ 
                     |_|   |_|            |___/            
                                                V-beta
        Development: Walderlan Sena - senawalderlan@gmail.com
             https://github.com/WalderlanSena/mappingdb
        \033[0m";
        fwrite(STDOUT, $splash);
    }

    public function init()
    {
        $this->splash();
        fwrite(STDOUT,  "\n\r");
        $fileDocument = fopen($this->args[2], "w");
        fwrite($fileDocument, "<?php\n");
        fwrite($fileDocument, "/**\n * Created by: MappingDB - https://github.com/WalderlanSena/mappingdb/  \n */\n\n");

        $namespace_file = "namespace " . $this->args[1] . ";" . "\n\n";
        fwrite($fileDocument, $namespace_file);

        $use = "use Doctrine\\ODM\\MongoDB\\Mapping\\Annotations as MongoDB;\n\n";
        fwrite($fileDocument, $use);

        $mongoDocument = "/**\n * @MongoDB\\Document()\n */\n";
        fwrite($fileDocument, $mongoDocument);

        $nameClass = "class ".str_replace('.php', '', $this->args[2])."\n{\n";
        fwrite($fileDocument, $nameClass);
        $mapping_default_one = "  /**\n   * @MongoDB\\";
        $mapping_default_two = "\n   */\n";

        $id = $mapping_default_one . "Id" . $mapping_default_two;
        fwrite($fileDocument, $id);
        $idType =  "   public $"."id;\n\n";
        fwrite($fileDocument, $idType);

        $option    = 'y';

        while (strtolower($option) == 'y') {
            fwrite(STDOUT, 'Enter the field name: ');
            $nameField = $this->readLine();
            fwrite(STDOUT, 'Enter the field type: ');
            $typeField = $this->readLine();

            if (!$this->verifyTypePermission($typeField)) {
                fwrite(STDOUT,'Type not permission !\n\n');
                continue;
            }

            $addField =  $mapping_default_one . "Field(type=" . '"' . $typeField . '"' . ")" . $mapping_default_two;
            fwrite($fileDocument, $addField);
            $addType  =  "   public $" . $nameField . ";" ."\n\n";
            fwrite($fileDocument, $addType);

            fwrite(STDOUT, 'Do you want to enter another field ? [Y/n] ');
            $option = $this->readLine();
        }
        fwrite($fileDocument, '}');
        fclose($fileDocument);
    }

    private function readLine()
    {
        if (PHP_OS === 'WINNT') {
            echo '$ ';
            $option = stream_get_line(STDIN, 1024, PHP_EOL);
        } else {
            $option = readline('$ ');
        }
        return $option;
    }

    private function verifyTypePermission($type)
    {
        $typePermission = [
            'bin',
            'bin_bytearray',
            'bin_custom',
            'bin_func',
            'bin_md5',
            'bin_uuid',
            'boolean',
            'collection',
            'custom_id',
            'date',
            'file',
            'float',
            'hash',
            'id',
            'int',
            'key',
            'object_id',
            'raw',
            'string',
            'timestamp',
        ];

        return in_array($type, $typePermission);
    }
}
