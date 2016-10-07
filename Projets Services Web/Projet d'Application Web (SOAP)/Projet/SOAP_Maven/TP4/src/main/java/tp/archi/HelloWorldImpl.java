
package tp.archi;

import javax.jws.WebService;

@WebService(endpointInterface = "tp.archi.HelloWorld")
public class HelloWorldImpl implements HelloWorld {

    public String sayHi(String text) {
        return "Hello " + text;
    }
}

