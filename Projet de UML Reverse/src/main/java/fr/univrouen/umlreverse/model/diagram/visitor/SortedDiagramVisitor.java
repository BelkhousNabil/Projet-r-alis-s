package fr.univrouen.umlreverse.model.diagram.visitor;

import java.util.Collections;
import java.util.HashMap;
import java.util.HashSet;
import java.util.Map;
import java.util.Set;

import fr.univrouen.umlreverse.model.diagram.common.IDiagram;
import fr.univrouen.umlreverse.model.diagram.clazz.view.IClassDiagram;
import fr.univrouen.umlreverse.model.diagram.clazz.view.ClassDiagram;
import fr.univrouen.umlreverse.model.diagram.usecase.UsecaseDiagram;
import fr.univrouen.umlreverse.model.diagram.usecase.IUsecaseDiagram;

/**
 * Returns a set of diagrams sorted by type.
 */
public class SortedDiagramVisitor implements IDiagramVisitor {
	private Map<Class<? extends IDiagram>, Set<IDiagram>> diagrams;

	public SortedDiagramVisitor() {
		diagrams = new HashMap<Class<? extends IDiagram>, Set<IDiagram>>();
	}
	
	// REQUESTS
	public Set<IDiagram> getDiagrams(Class<? extends IDiagram> type) {
		return Collections.unmodifiableSet(diagrams.getOrDefault(type, new HashSet<>()));
	}
	
	public Map<Class<? extends IDiagram>, Set<IDiagram>> getAllDiagrams() {
		return Collections.unmodifiableMap(diagrams);
	}
	
	// COMMANDS
	@Override
	public void visit(ClassDiagram diagram) {
		put(IClassDiagram.class, diagram);
	}

	@Override
	public void visit(UsecaseDiagram diagram) {
		put(IUsecaseDiagram.class, diagram);
	}
	
	// TOOLS
	private void put(Class<? extends IDiagram> key, IDiagram value) {
		if (!diagrams.containsKey(key)) {
			diagrams.put(key, new HashSet<IDiagram>());
		}
		diagrams.get(key).add(value);
	}
}
