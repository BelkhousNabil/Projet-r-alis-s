package fr.univrouen.umlreverse.model.diagram.visitor;

import fr.univrouen.umlreverse.model.diagram.clazz.view.ClassDiagram;
import fr.univrouen.umlreverse.model.diagram.clazz.visitor.ExportPlantUmlClassVisitor;
import fr.univrouen.umlreverse.model.diagram.usecase.UsecaseDiagram;

import java.io.File;

/**
 * A diagram visitor used to export to PlantUML
 */
public class ExportPlantUmlDiagramVisitor implements IDiagramVisitor {
    String error = null;
    File file;

    public ExportPlantUmlDiagramVisitor(File file) {
        this.file = file;
    }

    public String getError() {
        return error;
    }

    @Override
    public void visit(ClassDiagram diagram) {
        ExportPlantUmlClassVisitor visitor = new ExportPlantUmlClassVisitor(file);
        diagram.accept(visitor);
        error = visitor.getError();
    }

    @Override
    public void visit(UsecaseDiagram diagram) {
        /**ExportPlantUmlUsecaseVisitor visitor = new ExportPlantUmlUsecaseVisitor(file);
        diagram.accept(visitor);
        error = visitor.getError();*/
    }
}
