package org.Nabil.web.controller;

import org.junit.Test;

import static org.junit.Assert.assertEquals;

public class LandingPageControllerTest {

    @Test
    public void testShouldReturnCorrectLogicalViewName() {
        assertEquals("landing", new LandingPageController().getPage());
    }
}
