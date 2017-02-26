package fr.univrouen.umlreverse.model.diagram.visitor;

import fr.univrouen.umlreverse.model.diagram.clazz.view.ClassDiagram;
import fr.univrouen.umlreverse.model.diagram.usecase.UsecaseDiagram;

/**
 * A diagram visitor.
 */
public interface IDiagramVisitor {
    void visit(ClassDiagram diagram);
    void visit(UsecaseDiagram diagram);
}
