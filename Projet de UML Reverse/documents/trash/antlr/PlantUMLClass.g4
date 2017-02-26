grammar PlantUMLClass;

// Rules
compilationUnit
    : Start NL+ title? classList* NL? End NL? EOF
    ;

title
    : Title NL?
    ;

classList
    : packageRule
    | entity
    | relation
    ;

entity
    : enumRule
    | classRule
    ;

packageRule
    : PackageToken WS packageName WS? '{' NL+ classList* NL? '}' NL+
    ;

enumRule
    : EnumToken WS type WS? ('{' NL+ (name ','? NL)* '}')? NL+
    ;

classRule
    : ClassType WS type WS? ('{' NL+ field* '}')? NL+
    ;

packageName
    : (ID '.')* ID
    ;

field
    : attribute
    | method
    | '.'+ NL+
    ;

method
    : visibility WS? type WS name '(' argList? ')' NL+
    | visibility WS? name '(' argList? ')' WS? ':' WS? type NL+
    ;

attribute
    : visibility WS? arg NL+
    ;

argList
    : (arg WS? ',' WS?)* arg
    ;

arg
    : name WS? ':' WS? type
    | type WS name
    ;

relation
    : type WS (Escaped WS)? arrow WS (Escaped WS)? type NL+
    ;

visibility
    : '+'
    | '-'
    | 'o'
    | '#'
    ;

arrow
    : arrowHead? arrowBody arrowTail?
    ;

arrowHead
    : '<|'
    | '<'
    | 'o'
    | '*'
    ;

arrowBody
    : '-'+
    | '.'+
    ;

arrowTail
    : '|>'
    | '>'
    | 'o'
    | '*'
    ;

generic
    : '<' WS? type WS? '>'
    ;

type
    : (Struct WS)? (packageName '.')? ID WS? (generic WS?)? '[]'? (WS (Extends | Super | Implements) WS (type WS? ',')* WS? type)?
    ;

name
    : ID
    ;

// Tokens
Start: '@startuml';
End: '@enduml';

Title: 'title ' ~[\r\n]* '\n';
PackageToken: 'package';
EnumToken: 'enum';
ClassType: ('abstract class' | 'abstract' | 'class' | 'interface');
Extends : 'extends';
Super : 'super';
Implements : 'implements';
Struct : 'struct';
As: 'as';

ID
    : BasicLetter (BasicLetter | '-')*
    ;

BasicLetter
    : 'A'..'Z'
    | 'a'..'z'
    | '0'..'9'
    | '_'
    | '$'
    | '\u0080'..'\ufffe'
    ;

Escaped: '"' (~('"' | '\\' | '\r' | '\n') | '\\' ('"' | '\\'))* '"';


// Spaces
WS: (' ' | '\t')+;
NL: WS* ('\r'? '\n')+ WS*;

// Comments
COMMENT
    :   '/\'' .*? '\'/' -> skip
    ;

LINE_COMMENT
    :   '\'' ~[\r\n]* -> skip
    ;