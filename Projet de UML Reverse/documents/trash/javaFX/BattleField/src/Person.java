import static java.util.GregorianCalendar.YEAR;

import java.io.Serializable;
import java.util.GregorianCalendar;

public class Person implements Serializable
{
    private String firstname, lastname;
    private GregorianCalendar birthdate;
    private int age;

    public Person (String first, String last)
    {
        firstname = first;
        lastname = last;

    }

    public String getFirstname()
    {
        return firstname;
    }

    public String getLastname()
    {
        return lastname;
    }

    public GregorianCalendar getBirthdate()
    {
        return birthdate;
    }

    public int getAge()
    {
        return age;
    }
}