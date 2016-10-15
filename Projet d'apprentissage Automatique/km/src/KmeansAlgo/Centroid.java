package KmeansAlgo;

/**
 * 
 * @author BELKHOUS
 * 
 * class that represent the centroid
 */
	public class Centroid{
    private double coordinateX = 0.0;
    private double coordinateY = 0.0;
    
    /**
     * Default constructor
     */
    public Centroid(){
        
    }
    
    /**
     * Constructor
     * @param X
     * @param Y
     */
    public Centroid(double X, double Y){
        this.coordinateX = X;
        this.coordinateY = Y;
    }
    
    /**
     * Setter of coordinateX
     * @param X
     */
    public void setCoordinateX(double X){
        this.coordinateX = X;
    }
    
    /**
     * Getter of coordinateX
     * @return double value
     */
    public double getCoordinateX(){
        return this.coordinateX;
    }
    
    /**
     * Setter of coordinateY
     * @param Y
     */
    public void setCoordinateY(double Y){
        this.coordinateY = Y;
    }
    
    /**
     * Getter of  coordinateY
     * @return double value
     */
    public double getCoordinateY(){
        return this.coordinateY;
    }
}