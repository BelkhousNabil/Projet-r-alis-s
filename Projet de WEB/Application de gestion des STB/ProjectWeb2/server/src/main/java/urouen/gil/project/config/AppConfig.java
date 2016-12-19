package urouen.gil.project.config;

import org.springframework.context.annotation.Bean;
import org.springframework.context.annotation.ComponentScan;
import org.springframework.context.annotation.Configuration;
import org.springframework.web.multipart.commons.CommonsMultipartResolver;
import org.springframework.web.servlet.config.annotation.EnableWebMvc;
import urouen.gil.project.controller.Service;

import java.io.IOException;

@Configuration
@EnableWebMvc
@ComponentScan(basePackages = {"urouen.gil.project"})
public class AppConfig {

    @Bean
    public Service getService(){
        return new Service();
    }

    @Bean(name="multipartResolver")
    public CommonsMultipartResolver getResolver() throws IOException {
        CommonsMultipartResolver resolver = new CommonsMultipartResolver();
        resolver.setMaxUploadSizePerFile(5242880);//5MB
        return resolver;
    }

}
