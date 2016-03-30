package view;

/**
 * La Classe Data est un moule de se qu'on r&eacutecuperer dans les regles qu'on utilise pour definier le model de donn&eacutees pour les JTables
 * @author Anouar & Nabil
 *
 */
public class Data {
	
	private String RegleGauche;
	private String RegleDroite;
	private String Support;
	private String Confiance;
	private String Lift;
	
	/**
	 * @param regleGauche
	 * @param regleDroite
	 * @param support
	 * @param confiance
	 * @param lift
	 */
	public Data(String regleGauche, String regleDroite, String support, String confiance, String lift) {
		RegleGauche = regleGauche;
		RegleDroite = regleDroite;
		Support = support;
		Confiance = confiance;
		Lift = lift;
	}
	
	/* (non-Javadoc)
	 * @see java.lang.Object#toString()
	 */
	@Override
	public String toString() {
		return "Data [RegleGauche=" + RegleGauche + ", RegleDroite=" + RegleDroite + ", Support=" + Support
				+ ", Confiance=" + Confiance + ", Lift=" + Lift + "]";
	}

	/**
	 * @return the regleGauche
	 */
	public String getRegleGauche() {
		return RegleGauche;
	}
	/**
	 * @param regleGauche the regleGauche to set
	 */
	public void setRegleGauche(String regleGauche) {
		RegleGauche = regleGauche;
	}
	/**
	 * @return the regleDroite
	 */
	public String getRegleDroite() {
		return RegleDroite;
	}
	/**
	 * @param regleDroite the regleDroite to set
	 */
	public void setRegleDroite(String regleDroite) {
		RegleDroite = regleDroite;
	}
	/**
	 * @return the support
	 */
	public String getSupport() {
		return Support;
	}
	/**
	 * @param support the support to set
	 */
	public void setSupport(String support) {
		Support = support;
	}
	/**
	 * @return the confiance
	 */
	public String getConfiance() {
		return Confiance;
	}
	/**
	 * @param confiance the confiance to set
	 */
	public void setConfiance(String confiance) {
		Confiance = confiance;
	}
	/**
	 * @return the lift
	 */
	public String getLift() {
		return Lift;
	}
	/**
	 * @param lift the lift to set
	 */
	public void setLift(String lift) {
		Lift = lift;
	}
	
	
}
