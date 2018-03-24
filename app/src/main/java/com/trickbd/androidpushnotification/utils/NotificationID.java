package com.trickbd.androidpushnotification.utils;

import java.util.concurrent.atomic.AtomicInteger;

/**
 * Created by Rana on 11/14/2016.
 */
public class NotificationID {
    private final static AtomicInteger c = new AtomicInteger(0);
    public static int getID() {
        return c.incrementAndGet();
    }
}
