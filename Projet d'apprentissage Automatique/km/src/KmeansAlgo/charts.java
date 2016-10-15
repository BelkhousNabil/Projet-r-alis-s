package KmeansAlgo;

import org.knowm.xchart.XYChart;
import org.knowm.xchart.XYChartBuilder;
import org.knowm.xchart.XYSeries.XYSeriesRenderStyle;
import org.knowm.xchart.demo.charts.ExampleChart;
import org.knowm.xchart.style.Styler.LegendPosition;

/**
 * 
 * @author BELKHOUS
 * Version 1.0
 * Date 14 octobre
 * 
 * Class that permit to visualize the final result of the k-means clustering
 */
public class charts implements ExampleChart<XYChart> {

  @Override
  public XYChart getChart() {

    // Create Chart
    XYChart chart = new XYChartBuilder().width(800).height(600).build();

    // Customize Chart
    chart.getStyler().setDefaultSeriesRenderStyle(XYSeriesRenderStyle.Scatter);
    chart.getStyler().setChartTitleVisible(false);
    chart.getStyler().setLegendPosition(LegendPosition.OutsideE);
    chart.getStyler().setMarkerSize(16);

    // Series
    if(!KMeans.xData1.isEmpty()){
    	chart.addSeries("Cluster 1", KMeans.xData1, KMeans.yData1);	
    }
    if(KMeans.NUM_CLUSTERS >=1 && !KMeans.cxData1.isEmpty() ){
		chart.addSeries("Centroid 1", KMeans.cxData1, KMeans.cyData1);
	}
    
    if(!KMeans.xData2.isEmpty()){
    	chart.addSeries("Cluster 2", KMeans.xData2, KMeans.yData2);
    }
    if(KMeans.NUM_CLUSTERS >=2 && !KMeans.cxData2.isEmpty() ){
    	chart.addSeries("Centroid 2", KMeans.cxData2, KMeans.cyData2);
	}
    
    if(!KMeans.xData3.isEmpty()){
    	chart.addSeries("Cluster 3", KMeans.xData3, KMeans.yData3);
    }
    if(KMeans.NUM_CLUSTERS >=3 && !KMeans.cxData3.isEmpty() ){
    	chart.addSeries("Centroid 3", KMeans.cxData3, KMeans.cyData3);
	}
    
    if(!KMeans.xData4.isEmpty()){
    	chart.addSeries("Cluster 4", KMeans.xData4, KMeans.yData4);
    }
    if(KMeans.NUM_CLUSTERS >=4 && !KMeans.cxData4.isEmpty() ){
    	chart.addSeries("Centroid 4", KMeans.cxData4, KMeans.cyData4);
	}
    
    if(!KMeans.xData5.isEmpty()){
    	chart.addSeries("Cluster 5", KMeans.xData5, KMeans.yData5);
    }
    if(KMeans.NUM_CLUSTERS >=5 && !KMeans.cxData5.isEmpty() ){
    	chart.addSeries("Centroid 5", KMeans.cxData5, KMeans.cyData5);
	}
    
    if(!KMeans.xData6.isEmpty()){
    	chart.addSeries("Cluster 6", KMeans.xData6, KMeans.yData6);
    }
    if(KMeans.NUM_CLUSTERS >=6 && !KMeans.cxData6.isEmpty() ){
    	chart.addSeries("Centroid 6", KMeans.cxData6, KMeans.cyData6);
	}
    
    if(!KMeans.xData7.isEmpty()){
    	chart.addSeries("Cluster 7", KMeans.xData7, KMeans.yData7);
    }
    if(KMeans.NUM_CLUSTERS >=7 && !KMeans.cxData7.isEmpty() ){
    	chart.addSeries("Centroid 7", KMeans.cxData7, KMeans.cyData7);
	}
    
    if(!KMeans.xData8.isEmpty()){
    	chart.addSeries("Cluster 8", KMeans.xData8, KMeans.yData8);
    }
    if(KMeans.NUM_CLUSTERS >=8 && !KMeans.cxData8.isEmpty() ){
    	chart.addSeries("Centroid 8", KMeans.cxData8, KMeans.cyData8);
	}

    return chart;
  }

}