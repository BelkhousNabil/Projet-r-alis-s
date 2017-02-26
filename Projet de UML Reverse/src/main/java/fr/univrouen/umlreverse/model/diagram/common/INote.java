package fr.univrouen.umlreverse.model.diagram.common;

/**
 * A note to class diagram
 */
public interface INote extends IEntity {

// ATTRIBUTES
String TEXT_CHANGED_PROPERTY_NAME = "TextChanged";
    String STYLE_CHANGED_PROPERTY_NAME = "StyleChanged";
    
// REQUESTS

    /**
     * The text
     */
    String getText();


    // METHODS

    /**
     * Setter of text
     * @param text
     *      the new text
     */
    void setText(String text);
}
