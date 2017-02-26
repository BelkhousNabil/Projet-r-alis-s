grammar PlantUML;

// PRODUCTIONS
newline
    : '\n' newline?
    ;

visibility
    : '-'
    | '#'
    | '~'
    | '+'
    ;

modifier
    : '{' 'static' '}'
    | '{' 'abstract' '}'
    ;

methodName
    : Identifier
    ;

typeElement
    : Identifier ('[' ']')?
    ;

genericInheritance
    : 'extends'
    | 'super'
    ;

genericType
    : '<' typeName (genericInheritance typeName)? '>'
    ;

typeName
    : typeElement genericType?
    ;

attributeName
    : Identifier
    ;

argument
    : typeName attributeName
    | attributeName ':' typeName
    ;

argList
    : argument (',' argList)?
    ;

attributeElem
    : attributeName ':' typeName
    | typeName attributeName
    ;

attribute
    : visibility modifier? attributeElem newline
    ;

methodElem
    : methodName '(' argList? ')' ':' typeName
    | typeName methodName '(' argList? ')'
    ;

method
    : visibility modifier? methodElem newline
    ;

field
    : attribute
    | method
    ;

fieldList
    : field fieldList?
    ;

umlPackage
    : Identifier
    ;

umlPackageList
    : umlPackage ('.' umlPackage)*
    ;

classType
    : 'interface'
    | 'class'
    | 'abstract'
    | 'abstract' 'class'
    ;

className
    : Identifier genericType?
    ;

classDesc
    : classType className
    | classType umlPackageList '.' className
    ;

classElem
    : classDesc '{' newline fieldList? '}' newline
    ;

identifierList
    : Identifier (',' newline identifierList)?
    ;

enumDesc
    : 'enum' className
    | 'enum' umlPackageList '.' className
    ;

enumElem
    : enumDesc '{' newline identifierList? '}' newline
    ;

umlClass
    : classElem
    | enumElem
    ;

relationHead
    : '<'
    | '<' '|'
    | 'o'
    | '*'
    ;

relationTail
    : '>'
    | '|' '>'
    | 'o'
    | '*'
    ;

pointList
    : '.' pointList?
    ;

subList
    : '-' subList?
    ;

relationBody
    : subList
    | pointList
    ;

relationLabel
    : StringIdentifier
    ;

relation
    : relationHead? relationBody relationTail?
    ;

classRelation
    : className relationLabel? relation relationLabel? className (':' relationLabel)?
    ;

note
    : 'note' StringIdentifier* ('as' className)? ':' StringIdentifier* newline
    | 'note' StringIdentifier* ('as' className)? '{' newline (StringIdentifier* '\n')* '}'
    ;

umlClassElement
    : classRelation
    | umlClass
    | note
    ;

umlClassElementList
    : umlClassElement newline umlClassElementList?
    ;

startUml
    : newline? '@' 'startuml' newline
    ;

endUml
    : newline '@' 'enduml' newline?
    ;

classPlantUML
    :  umlClassElementList
    | 'package' umlPackageList '{' newline classPlantUML? '}' newline
    ;

title
    : 'title' StringIdentifier* newline
    | 'title' NoQuoteString newline
    ;

compilationUnit
    : startUml title? classPlantUML endUml
    ;

// LEXER
// Keywords
STATIC : 'static';
ABSTRACT : 'abstract';
EXTENDS : 'extends';
SUPER : 'super';
CLASS : 'class';
INTERFACE : 'interface';
ENUM : 'enum';
PACKAGE : 'package';
STARTUML : 'startuml';
ENDUML : 'enduml';
NOTE : 'note';
AS : 'as';

// Separators
NEWLINE : '\n';
LPAREN : '(';
RPAREN : ')';
LBRACE : '{';
RBRACE : '}';
LBRACK : '[';
RBRACK : ']';
COLON : ':';
ADD : '+';
SUB : '-';
MUL : '*';
HASH : '#';
GT : '>';
LT : '<';
OR : '|';
UNDERSCORE : '_';
DOT : '.';
COMMA : ',';
ASLASH : '\\';
SLASH : '/';
AT : '@';
QUOTE : '\'';
DQUOTE : '"';

// Identifiers
Identifier
	: BasicLetter BasicLetterOrDigit*
	;

StringIdentifier
    : DQUOTE EscapedLetter* DQUOTE
    ;

NoQuoteString
    : EscapedLetter+
    ;

fragment
BasicLetter
    : [a-zA-Z$_]
    ;

fragment
BasicLetterOrDigit
    : [a-zA-Z0-9$_]
    | SUB
    ;

fragment
EscapedLetter
    : [^(\'\"\n)]
    | [0-9]
    ;

// Other
WS
    :  [ \t\r\u000C]+ -> skip
    ;

COMMENT
    :   '/\'' .*? '\'/' -> skip
    ;