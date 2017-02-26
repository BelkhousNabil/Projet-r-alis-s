package fr.univrouen.umlreverse.ui.component.common.relation;

import java.util.ArrayList;
import java.util.HashMap;
import java.util.HashSet;
import java.util.List;
import java.util.Map;
import java.util.Set;
import java.util.function.Consumer;

import fr.univrouen.umlreverse.model.diagram.common.TypeHeadArrow;
import fr.univrouen.umlreverse.model.diagram.common.TypeLineArrow;
import fr.univrouen.umlreverse.ui.component.common.elements.IEntityGraphic;
import fr.univrouen.umlreverse.ui.component.common.elements.ISelectionableEntityGraphic;
import fr.univrouen.umlreverse.ui.component.common.relation.EntityPoint.Side;
import fr.univrouen.umlreverse.ui.component.common.relation.type.RelationTypeEnum;
import fr.univrouen.umlreverse.ui.component.usecase.elements.IUsecaseGraphic;
import fr.univrouen.umlreverse.ui.view.common.IDiagramEditorController;
import fr.univrouen.umlreverse.util.Contract;
import javafx.beans.property.ObjectProperty;
import javafx.beans.property.SimpleObjectProperty;
import javafx.beans.value.ChangeListener;
import javafx.beans.value.ObservableValue;
import javafx.event.EventHandler;
import javafx.event.EventType;
import javafx.geometry.Point2D;
import javafx.scene.Group;
import javafx.scene.input.ContextMenuEvent;
import javafx.scene.input.MouseEvent;
import javafx.scene.paint.Color;
import javafx.scene.shape.Circle;
import javafx.scene.shape.Line;
import javafx.scene.shape.Shape;
import javafx.scene.text.Text;
import javafx.scene.transform.Scale;

/**
 * Implements IRelationGraphic and ISelectionableEntityGraphic.
 */
public abstract class ARelationGraphic implements ISelectionableEntityGraphic, 
        IRelationGraphic {
 
// ATTRIBUTES
    private boolean isSelected;
    private final IDiagramEditorController diagramEditorController;

    private Group group;   
    protected final IArrowHead arrowTail;
    protected final IArrowBody arrowBody;
    protected final IArrowHead arrowHead; 
    protected final EntityPoint sideSrc;
    protected final EntityPoint sideDst; 
    protected final Text nameText; 
    private final ObjectProperty<TypeHeadArrow> headProperty;
    private final ObjectProperty<TypeHeadArrow> tailProperty;
    private EventType<ContextMenuEvent> menuEvent;
    private EventHandler<? super ContextMenuEvent> menuEventHandler;   
    private final Map<EventType<MouseEvent>, EventHandler<? super MouseEvent>> events;
      
// CONSTRUCTORS
    /**
     * 
     * @param diagramEditorController
     * @pre
     *      diagramEditorController != null 
     */
    public ARelationGraphic(IDiagramEditorController diagramEditorController) {
        Contract.check(diagramEditorController != null, 
                "diagramEditorController must not be null.");
        this.diagramEditorController = diagramEditorController;
        sideSrc = new EntityPoint();
        sideDst = new EntityPoint();      
        Color c = Color.web(IDiagramEditorController.COLOR_DEFAULT_RELATION);
        arrowTail = new ArrowHead(TypeHeadArrow.None, Point2D.ZERO, Side.TOP, c);
        arrowHead = new ArrowHead(TypeHeadArrow.None, Point2D.ZERO, Side.TOP, c);
        arrowBody = new ArrowBody(0, 0, 0, 0, arrowTail.tailPointProperty(), arrowHead.tailPointProperty());
        arrowBody.setColor(c);     
        nameText = new Text();       
        events = new HashMap<>();
        headProperty = new SimpleObjectProperty<>();
        tailProperty = new SimpleObjectProperty<>();
        createController();
    }
    
// REQUESTS
    @Override
    public List<Circle> getArrowBodyCircles() {
        Contract.check(arrowBody != null, "arrowBody must not be null.");
        return arrowBody.getCircles();
    }
    
    @Override
    public String getCardinalityEnd() {
        return getController().getCardinalityEnd();
    }
    
    @Override
    public Text getCardinalityEndText() {
        return arrowHead.getText();
    }
    
    @Override
    public String getCardinalityStart() {
        return getController().getCardinalityStart();
    }
    
    @Override
    public Text getCardinalityStartText() {
        return arrowTail.getText();
    }
    
    @Override
    public Circle getCircleDst() {
        Contract.check(arrowHead != null, "arrowHead must not be nulll.");
        return arrowHead.getHeadCircle();
    }
    
    @Override
    public Circle getCircleSrc() {
        Contract.check(arrowTail != null, "arrowTail must not be nulll.");
        return arrowTail.getHeadCircle();
    }
    
    @Override
    public Color getColorRelation() {
        return getController().getColorRelation();
    }
    
    @Override
    public Color getColorText() {
        return getController().getColorText();
    }
    
    public abstract IRelationGraphicController getController();
    
    @Override
    public IEntityGraphic getEntityDst() {
        return getController().getGEntityDst();
    }
    
    @Override
    public IEntityGraphic getEntitySrc() {
        return getController().getGEntitySrc();
    }
    
    @Override
    public Line getFirstLine() {
        return arrowBody.getFisrtLine();
    }
    
    @Override
    public List<Line> getHeadLines() {
        return arrowHead.getLines();
    }  
 
    @Override
    public String getName() {
        return getController().getName();
    }
    
    @Override
    public Text getNameText() {
        return nameText;
    }
    
    @Override
    public Set<Shape> getShapes() {
        Set<Shape> res = new HashSet<>(getArrowShapes());
        res.add(nameText);
        return res;
    }    
    
    @Override
    public List<Line> getTailLines() {
        return arrowTail.getLines();
    }
    
    @Override
    public RelationTypeEnum getType() {
        return getController().getType();
    }
    
    @Override
    public boolean isSelected() {
        return isSelected;
    }   

// COMMANDS 

    @Override
    public void clear() {      
        getArrowShapes().stream().map((s) -> {
            s.removeEventHandler(menuEvent, menuEventHandler);
            return s;
        }).forEach(new Consumer<Shape>() {
            @Override
            public void accept(Shape s) {
                events.keySet().stream().forEach((event) -> {
                    s.removeEventHandler(event, events.get(event));
                });
            }
        });
        arrowBody.clearAll();
        getController().clear();
    }

    @Override
    public void drawInGroup(Group g) {
        Contract.check(g != null, "g must not be null.");
        group = g;
        drawArrowBodyInGroup();
        group.getChildren().addAll(arrowHead.getShapes());
        group.getChildren().addAll(arrowTail.getShapes());
        group.getChildren().add(nameText);
    }
    
    @Override
    public void moveArrowBodyPoint(Circle c, double x, double y) {
        Contract.check(c != null, "c must not be null.");
        arrowBody.movePoint(c, x, y);
    }
    
    @Override
    public final void moveArrowHead(double x, double y) {
        IEntityGraphic dst = getController().getGEntityDst();      
        Point2D pDst = dst.getCenterPoint();
        double xDst = pDst.getX();
        double yDst = pDst.getY();
        double wDst = dst.getWidth() / 2;
        double hDst = dst.getHeight() / 2;
        double x1 = xDst - wDst;
        double x2 = xDst + wDst;
        double y1 = yDst - hDst;
        double y2 = yDst + hDst;
        
        if (x1 < x && x < x2 && y1 < y && y < y2) {
            return;
        }          
        double newX;
        double newY;
        Side side = arrowHead.getSide();
        
        if (x <= x1) {
            newX = x1;
            side = Side.LEFT;
        } else if (x >= x2) {
            newX = x2;
            side = Side.RIGHT;
        } else {
            newX = x;
        }
        
        if (y <= y1) {
            newY = y1;
            side = Side.TOP;
        } else if (y >= y2) {
            newY = y2;
            side = Side.BOTTOM;
        } else {
            newY = y;
        }
        
        Point2D newPoint = new Point2D(newX, newY);
        
        arrowHead.moveHeadPoint((dst instanceof IUsecaseGraphic)
        		? new Scale(wDst, hDst, xDst, yDst).transform(
        				pDst.add(newPoint.subtract(pDst).normalize()))
        		: newPoint);
        arrowHead.setSide(side);
    }
    
    @Override
    public final void moveArrowTail(double x, double y) {
        
        IEntityGraphic src = getController().getGEntitySrc();  
        Point2D pSrc = src.getCenterPoint();
        double xSrc = pSrc.getX();
        double ySrc = pSrc.getY();
 
        double wSrc = src.getWidth() / 2;
        double hSrc = src.getHeight() / 2;
        
        double x1 = xSrc - wSrc;
        double x2 = xSrc + wSrc;
        double y1 = ySrc - hSrc;
        double y2 = ySrc + hSrc;
        
        if (x1 < x && x < x2 && y1 < y && y < y2) {
            return;
        }
        
        double newX;
        double newY;
        Side side = arrowTail.getSide();
        
        if (x <= x1) {
            newX = x1;
            side = Side.LEFT;
        } else if (x >= x2) {
            newX = x2;
            side = Side.RIGHT;
        } else {
            newX = x;
        }
        
        if (y <= y1) {
            newY = y1;
            side = Side.TOP;
        } else if (y >= y2) {
            newY = y2;
            side = Side.BOTTOM;
        } else {
            newY = y;
        }
        
        Point2D newPoint = new Point2D(newX, newY);
        
        arrowTail.moveHeadPoint((src instanceof IUsecaseGraphic)
        		? new Scale(wSrc, hSrc, xSrc, ySrc).transform(
        				pSrc.add(newPoint.subtract(pSrc).normalize()))
        		: newPoint);
        arrowTail.setSide(side);
    }
    
    @Override
    public void nameTextAutoSize() {
        List<Circle> circles = arrowBody.getCircles();
        Circle c = circles.get(circles.size() / 2);
        nameText.setLayoutX(c.getCenterX() + MARGE_TEXT);
        nameText.setLayoutY(c.getCenterY() + MARGE_TEXT);
    }

    @Override
    public void setCardinalityEnd(String cardinalityEnd) {
        Contract.check(cardinalityEnd != null, "cardinalityEnd must not be null.");
        getController().setCardinalityEnd(cardinalityEnd);
    }
    
    @Override
    public void setCardinalityStart(String cardinalityStart) {
        Contract.check(cardinalityStart != null, "cardinalityStart must not be null.");
        getController().setCardinalityStart(cardinalityStart);
    }
    
    @Override
    public void setColorRelation(Color colorRelation) {
        Contract.check(colorRelation != null, "colorRelation must not be null.");
        getController().setColorRelation(colorRelation);
    }

    @Override
    public void setColorShapes(Color c) {
        Contract.check(c != null, "c must not be null.");
        arrowBody.setColor(c);
        arrowHead.setColor(c);
        arrowTail.setColor(c);
    }
    
    @Override
    public void setColorText(Color colorText) {
        Contract.check(colorText != null, "colorText must not be null.");
        getController().setColorText(colorText);
    }
    
    @Override
    public void setContextMenuEventOnArrow(EventType<ContextMenuEvent> eventType,
            final EventHandler<? super ContextMenuEvent> eventHandler) {
        Contract.check(eventType != null, "eventType must not be null.");
        Contract.check(eventHandler != null, "eventHandler must not be null.");
        getArrowShapes().stream().forEach((s) -> {
            s.addEventHandler(eventType, eventHandler);
        });
        menuEvent = eventType;
        menuEventHandler = eventHandler;
    }
    
    @Override
    public void setDNDPointEvent(EventHandler<MouseEvent> pointDnd_Event) {
        Contract.check(pointDnd_Event != null, "c must not be null.");
        arrowBody.setDNDPointEvent(pointDnd_Event);
    }
    
    @Override
    public void setName(String name) {
        Contract.check(name != null, "name must not be null.");
        getController().setName(name);
    }
    
    @Override
    public void setMouseEventOnArrow(EventType<MouseEvent> eventType,
            final EventHandler<? super MouseEvent> eventHandler) {
        getArrowShapes().stream().forEach((s) -> {
            s.addEventHandler(eventType, eventHandler);
        });
        events.put(eventType, eventHandler);
    }
    
    @Override
    public void setSelected(boolean b) {
        if (b) {
            diagramEditorController.setSelectedEntity(this);
        }
        isSelected = b;
    }
     
    @Override
    public void setType(RelationTypeEnum type) {
        getController().setType(type);
    }
    
    @Override
    public void setTypeArrowHead(TypeHeadArrow head) {
        Contract.check(head != null, "head must not be null.");
        headProperty.setValue(head);
    }
    
    @Override
    public void setTypeArrowTail(TypeHeadArrow tail) {
        Contract.check(tail != null, "tail must not be null.");
        tailProperty.setValue(tail);
    }
    
    @Override
    public final void setTypeLineArrow(TypeLineArrow line) {
        Contract.check(line != null, "line must not be null.");
        if (line == TypeLineArrow.Dashed) {
            arrowBody.setDashed(DASH_DEFAULT);
            arrowTail.setDashed(DASH_DEFAULT);
            arrowHead.setDashed(DASH_DEFAULT);
        } else if (line == TypeLineArrow.Plain) {
            arrowBody.setDashed(0);
        } 
    }

// PRIVATE 
    
    private void createController() {
         headProperty.addListener(new ChangeListener<TypeHeadArrow>() {
             @Override
             public void changed(ObservableValue<? extends TypeHeadArrow> observable, TypeHeadArrow oldValue, TypeHeadArrow newValue) {
                 updateHead(newValue);
             }
         });       
        tailProperty.addListener(new ChangeListener<TypeHeadArrow>() {
             @Override
             public void changed(ObservableValue<? extends TypeHeadArrow> observable, TypeHeadArrow oldValue, TypeHeadArrow newValue) {
                 updateTail(newValue);
             }
         });     
        sideDst.sideProperty().addListener(new ChangeListener<Side>() {
             @Override
             public void changed(ObservableValue<? extends Side> observable, Side oldValue, Side newValue) {
                 arrowHead.setSide(newValue);
             }
         });     
        sideDst.pointProperty().addListener(new ChangeListener<Point2D>() {
             @Override
             public void changed(ObservableValue<? extends Point2D> observable, Point2D oldValue, Point2D newValue) {
                 arrowHead.moveHeadPoint(newValue);
             }
         });
        sideSrc.sideProperty().addListener(new ChangeListener<Side>() {
             @Override
             public void changed(ObservableValue<? extends Side> observable, Side oldValue, Side newValue) {
                 arrowTail.setSide(newValue);
             }
         });
        sideSrc.pointProperty().addListener(new ChangeListener<Point2D>() {
             @Override
             public void changed(ObservableValue<? extends Point2D> observable, Point2D oldValue, Point2D newValue) {
                 arrowTail.moveHeadPoint(newValue);
             }
         });
    }
    
    protected Direction getDirectionOfDestination() {
        IEntityGraphic src = getController().getGEntitySrc();
        IEntityGraphic dst = getController().getGEntityDst();
        
        Point2D pSrc = src.getCenterPoint();
        Point2D pDst = dst.getCenterPoint();
        double xSrc = pSrc.getX();
        double ySrc = pSrc.getY();
        double xDst = pDst.getX();
        double yDst = pDst.getY();
        double wSrc = src.getWidth() / 2;
        double hSrc = src.getHeight() / 2;
        double wDst = dst.getWidth() / 2;
        double hDst = dst.getHeight() / 2;
        
        if (src == dst) {
            return Direction.NULL;
        }
        
        if (yDst < ySrc && xDst + wDst > xSrc - wSrc && xDst - wDst < xSrc + wSrc)
            // Si dst plut haut que src et dst.droite.x > src.gauche.x et dst.gauche.x < src.droite.x
            return Direction.NORTH;
        else if (xDst - wDst >= xSrc + wSrc && yDst + hDst <= ySrc - hSrc)
            // Si dst.gauche.x >= src.droite.x et dst.y.bas <= src.x.haut
            return Direction.NORTH_EST;
        else if (xDst > xSrc && yDst + hDst > ySrc - hSrc && yDst - hDst < ySrc + hSrc)
            // Si dst a droite de src et dst.bas.y > src.haut.y et dst.haut.y < src.bas.y
            return Direction.EST;
        else if (yDst - hDst >= ySrc + hSrc && xDst - wDst >= xSrc + wSrc)
            // Si dst.haut.y >= src.bas.y et dst.gauche.x >= src.droite.x
            return Direction.SOUTH_EST;
        else if (yDst > ySrc && xDst - wDst < xSrc + wSrc && xDst + wDst > xSrc - wSrc)
            // Si dst est en bas de src et dst.gauche.x < src.droite.x et dst.droite.x > src.gauche.x 
            return Direction.SOUTH;
        else if (xDst + wDst <= xSrc - wSrc && yDst - hDst >= ySrc + hSrc)
            // Si dst.droite.x <= src.gauche.x et dst.haut.y >= src.Bas.y
            return Direction.SOUTH_WEST;
        else if (xDst < xSrc && yDst - hDst < ySrc + hSrc && yDst + hDst > ySrc - hSrc)
            // Si dst est à gauche de src et dst.haut.y < src.bas.y et dst.bas.y > src.haut.y
            return Direction.WEST;
        else
            return Direction.NORTH_WEST;
    }

    private List<Shape> getArrowShapes() {
        List<Shape> arrow = new ArrayList<>(arrowBody.getLines()); 
        arrow.addAll(arrowHead.getShapes());
        arrow.addAll(arrowTail.getShapes());
        return arrow; 
    }
     
    protected final void updateHead(TypeHeadArrow newValue) {
        arrowHead.setType(newValue);
    }
     
    protected final void updateTail(TypeHeadArrow newValue) {
       arrowTail.setType(newValue);
    }
    
    protected void clearArrowBodyInGroup() {
        if (group != null) {
            group.getChildren().removeAll(arrowBody.getShapes());
        }
    }
    
    protected void drawArrowBodyInGroup() {
        if (group != null) {
            arrowBody.getShapes().stream().filter((s) -> (!group.getChildren().contains(s))).forEach((s) -> {
                group.getChildren().add(s);
            });
            arrowBody.getLines().stream().map((l) -> {
                l.addEventHandler(menuEvent, menuEventHandler);
                return l;
            }).forEach(new Consumer<Line>() {
                @Override
                public void accept(Line l) {
                    events.keySet().stream().forEach((event) -> {
                        l.addEventHandler(event, events.get(event));
                    });
                }
            });
        }
    }
    
// ENUM
    public enum Direction {
        NORTH, NORTH_EST, EST, SOUTH_EST, SOUTH, SOUTH_WEST, WEST, NORTH_WEST, NULL
    }
}
