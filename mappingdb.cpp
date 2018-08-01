/**
 *  MappingDB - Doctrine Mongodb Document Mapping Generator
 *  @Version  : vbeta
 *  @author   : Walderlan Sena <walderlan@mentesvirtuaissena.com>
 *  @site     : https://www.mentesvirtuaissena.com
 *  @code     : https://github.com/WalderlanSena/mappingdb
 *  @license  : MIT 
 *
 */ 
#include <iostream>
#include <fstream>
#include <string>

using namespace std;


int main(int argc, char **argv)
{ 
    fstream file;
    
    if (argc < 3) {
        cout << "MappingDB - Doctrine Mongodb Document Mapping Generator - V-beta" << endl; 
        cout << "Usage: ./mappingDB namespace document" << endl;
        cout << "Ex: ./mappingdb App\\Domain\\Document User.php" << endl;
        exit(1);
    }

    char option = 'y';
    
    string name;
    string type;

    file.open(argv[2], ios::out);
    
    file << "<?php\n\n";
    file << "namespace " << argv[1] << ";" << endl << endl;
    file << "use Doctrine\\ODM\\MongoDB\\Mapping\\Annotations as MongoDB;\n\n";

    file << "/**\n * @MongoDB\\Document()\n */\n";

    file << "class User\n";
    file << "{\n";

    string mapping_default_one = "  /**\n   * @MongoDB\\";
    string mapping_default_two = "\n   */\n";
    
    file <<  mapping_default_one << "Id" << mapping_default_two;
    file <<  "   public $id;\n\n";
    

    while(option == 'y' || option == 'Y') {
        cout << "Enter the field name:  ";
            cin >> name;
        cout << "Enter the field type:  ";
            cin >> type;
        
        file <<  mapping_default_one << "Field(type=" << "'" << type << "'" << ")" << mapping_default_two;
        file <<  "   public $" << name << ";" << endl << endl;

        cout << endl << "Do you want to enter another field ? [Y/n] ";
            cin >> option;
    }

    file << "}";

    file.close();
    
    return 0;
}
