package tp.archi;

import java.util.Scanner;

import org.apache.camel.CamelContext;
import org.apache.camel.Exchange;
import org.apache.camel.ProducerTemplate;
import org.apache.camel.builder.RouteBuilder;
import org.apache.camel.impl.DefaultCamelContext;
import org.apache.log4j.BasicConfigurator;

public class ProducerConsumer {

	public static void main(String[] args) throws Exception {
		 
		Scanner sc = new Scanner(System.in);
		
		
		
		
		BasicConfigurator.configure();
		
		CamelContext context = new DefaultCamelContext();
		
		RouteBuilder routeBuilder  = new RouteBuilder() {
			
			@Override
			public void configure() throws Exception {
				from("direct:consumer-1").to("log:affiche-1-log");
				from("direct:consumer-2").to("file:message");
				from("direct:consumer-all").choice()
						.when(header("hearderEntete").isEqualTo("écrire")).to("direct:consumer-2")
							.otherwise().to("direct:consumer-1");
				from("direct:CityManager").setHeader(Exchange.HTTP_METHOD,constant("GET")).setHeader(Exchange.HTTP_QUERY, simple("ville=${header.ville}")).to("http://127.0.0.1:8084")
							.log("response received: ${body}");
				from("direct:Geonames").setHeader(Exchange.HTTP_METHOD,constant("GET")).setHeader(Exchange.HTTP_QUERY, simple("q=${header.villeName}&username=m1gil")).to("http://api.geonames.org/search")
				.log("response received: ${body}");
				from("direct:m1gil").to("jgroups:m1gil").log("le mot-clé est : ${body}");
			}
		};
		
		routeBuilder.addRoutesToCamelContext(context);
		
		context.start();
		
		ProducerTemplate pt = context.createProducerTemplate();
		
		// Questions 1.A & 1.B & 2.A & 2.B & 2.C
 		String msg = "";
		System.out.println("Donner votre message ou exit pour sortir!!");
		while(!(msg  = sc.nextLine()).equals("exit")){		
			String headValue = "";
			if(msg.startsWith("w")){
				headValue = "écrire";
			}
			pt.sendBodyAndHeader("direct:consumer-all", msg, "hearderEntete", headValue);
			System.out.println("Donner votre message ou exit pour  sortir!!");
		}

		// Question 3.A
		String villeName = "";
		System.out.println("Donner le nom de la ville !!");
		while(!(villeName  = sc.nextLine()).equals("exit")) {
			pt.sendBodyAndHeader("direct:CityManager", "", "ville", villeName);
			System.out.println("Donner le nom de la ville !!");
		}

		// Question 3.B
		String villeSearchName = "";
		System.out.println("Donner le nom de la ville avec l'API GeoName ou exit pour sortir!");
		while(!(villeSearchName  = sc.nextLine()).equals("exit")){		
			pt.sendBodyAndHeader("direct:Geonames","","villeName", villeSearchName);
			System.out.println("Donner le nom de la ville avec l'API GeoName ou exit pour sortir!");
		}

		// Question 4
		String msgJGroupe = "";
		System.out.println("Donner votre message ou exit pour sortir!!");
		while(!(msgJGroupe  = sc.nextLine()).equals("exit")){		
			pt.sendBody("direct:m1gil", msgJGroupe);
			System.out.println("Donner votre message ou exit pour sortir!!");
		}
		
	}
}
