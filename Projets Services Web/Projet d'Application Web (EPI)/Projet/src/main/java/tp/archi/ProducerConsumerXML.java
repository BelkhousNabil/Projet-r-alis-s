package tp.archi;

import java.util.Scanner;
import org.apache.camel.CamelContext;
import org.apache.camel.ProducerTemplate;
import org.apache.log4j.BasicConfigurator;
import org.springframework.context.support.FileSystemXmlApplicationContext;

public class ProducerConsumerXML {
    public static void main(String[] args) throws Exception {

        BasicConfigurator.configure();
		FileSystemXmlApplicationContext bean = new FileSystemXmlApplicationContext("src/main/resources/routes.xml");

		CamelContext context = bean.getBean("routesXML", CamelContext.class);
        ProducerTemplate template = context.createProducerTemplate();
        Scanner sc = new Scanner(System.in);

        // Questions 1.A & 1.B & 2.A & 2.B & 2.C
		String msg = "";
		System.out.println("Donner votre message ou exit pour sortir!!");
		while(!(msg  = sc.nextLine()).equals("exit")){
			String headValue = "";
			if(msg.startsWith("w")){
				headValue = "écrire";
			}
            template.sendBodyAndHeader("direct:consumer-all", msg, "hearderEntete", headValue);
			System.out.println("Donner votre message ou exit pour exit pour sortir!!");
		}

        // Question 3.A
        String villeName = "";
		System.out.println("Donner le nom de la ville !!");
		while(!(villeName  = sc.nextLine()).equals("exit")){
			template.sendBodyAndHeader("direct:CityManager","","ville", villeName);
			System.out.println("Donner le nom de la ville !!");
		}

        // Question 3.B
		String villeSearchName = "";
		System.out.println("Donner le nom de la ville avec l'API GeoName ou exit pour exit pour sortir!");
		while(!(villeSearchName  = sc.nextLine()).equals("exit")){
			template.sendBodyAndHeader("direct:Geonames","","villeName", villeSearchName);
			System.out.println("Donner le nom de la ville avec l'API GeoName ou exit pour exit pour sortir!");
		}

        // Question 4
        String msgJGroupe = "";
        System.out.println("Donner votre message ou exit pour sortir!!");
        while(!(msgJGroupe  = sc.nextLine()).equals("exit")){
            template.sendBody("direct:m1gil", msgJGroupe);
            System.out.println("Donner votre message ou exit pour exit pour sortir!!");
        }
	}

}
