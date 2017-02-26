package fr.univrouen.umlreverse.model.diagram.common;

import static fr.univrouen.umlreverse.model.diagram.common.IDiagram.NOTE_STYLE_ID;

import fr.univrouen.umlreverse.ui.component.common.relation.type.RelationTypeEnum;

/**
 * ANote abstract class that permits to represent a note that can be used by all of the Diagrams (Common code)
 */
public abstract class ANote extends AEntityRelation implements INote {
// ATTRIBUTES  
    private String text = "";

// CONSTRUCTOR

    public ANote(String text, IDiagramCommon d) {
        super(d);
        this.text = text;
    }

    // REQUESTS
    
    @Override
    public String getStyleId() {
        return NOTE_STYLE_ID;
    }

    @Override
    public String getText() {
        return text;
    }

// COMMANDS
    @Override
    public void addRelation(IEntityRelation entity) {
    	super.addRelation(entity);
    	IRelation relation = relations.get(entity);
    	relation.setArrowHead(RelationTypeEnum.NOTE.getHead());
    	relation.setLineArrow(RelationTypeEnum.NOTE.getLine());
    	relation.setArrowTail(RelationTypeEnum.NOTE.getTail());
    }
    
    @Override
    public void addRelationDst(IRelation relation, IEntityRelation entity) {
    	super.addRelationDst(relation, entity);
    	relation.setArrowHead(RelationTypeEnum.NOTE.getHead());
    	relation.setLineArrow(RelationTypeEnum.NOTE.getLine());
    	relation.setArrowTail(RelationTypeEnum.NOTE.getTail());
    }
    
    @Override
    public void setText(String text) {
        if (!this.text.equals(text)) {
            String oldText = this.text;
            this.text = text;
            firePropertyChange(TEXT_CHANGED_PROPERTY_NAME, oldText, text);
        }
    }
}
