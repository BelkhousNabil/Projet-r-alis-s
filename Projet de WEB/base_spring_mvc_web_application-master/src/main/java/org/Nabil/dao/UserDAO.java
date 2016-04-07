package org.Nabil.dao;

import com.avaje.ebean.Ebean;
import org.Nabil.domain.User;
import org.Nabil.uuid.UUIDFactory;

import javax.annotation.Resource;
import java.util.Map;
import java.util.concurrent.ConcurrentHashMap;

public class UserDAO {

    public User findByEmail(String email) {
        return Ebean.find(User.class)
                .where().eq("email", email)
                .findUnique();
    }

    public void save(User user) {
        Ebean.save(user);
    }

    public void delete(String id) {
        Ebean.delete(User.class, id);
    }
}
