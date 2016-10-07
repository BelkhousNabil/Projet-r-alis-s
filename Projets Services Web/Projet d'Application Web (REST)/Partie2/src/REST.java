import java.io.StringReader;

import javax.xml.transform.Source;
import javax.xml.transform.stream.StreamSource;
import javax.xml.ws.Endpoint;
import javax.xml.ws.Provider;
import javax.xml.ws.ServiceMode;
import javax.xml.ws.WebServiceProvider;
import javax.xml.ws.http.HTTPBinding;
import javax.xml.ws.Service;

@WebServiceProvider
@ServiceMode(value=Service.Mode.PAYLOAD)
 
public class REST implements Provider<Source>{

	String SendMessage;
	
	public REST(String message) {
		this.SendMessage = message;
	}
	
	@Override
	public Source invoke(Source source) {
			
		// La donner qu'on va envoyer
		String replyElement = new String(SendMessage);
		//ouverture d'un flux de donn�es
		StreamSource replay = new StreamSource(new StringReader(replyElement));
		// retour du flux de donn�es
		return replay;
	}
	
	public static void main(String[] args) {
		// creation d'un web service : qui nous donnera du HTML, et renvera le flux q'on a envoy�
		Endpoint e = Endpoint.create(HTTPBinding.HTTP_BINDING, new REST("<p>Universit� de Rouen</p>"));
		// publication du web service cr�e 
		//e.publish("http://127.0.0.1:8084/hello/world");
		
		Endpoint e2 = Endpoint.create(HTTPBinding.HTTP_BINDING, new REST("<p>R�ponse du service REST</p>"));
		// publication du flux de donn�es 
		e2.publish("http://127.0.0.1:8090/test");
		
		Endpoint e3 = Endpoint.create(HTTPBinding.HTTP_BINDING, new REST("<p>R�ponse du service REST</p>"));
		// publication du flux de donn�es 
		e3.publish("http://127.0.0.1:8084/hello/world");
	}


}
