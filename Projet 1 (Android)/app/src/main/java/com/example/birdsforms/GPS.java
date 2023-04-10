package com.example.birdsforms;

import static android.content.Context.LOCATION_SERVICE;

import android.app.Activity;
import android.content.Context;
import android.content.pm.PackageManager;
import android.location.LocationManager;
import android.os.Build;

import androidx.annotation.Nullable;
import androidx.core.app.ActivityCompat;
import androidx.core.content.ContextCompat;


public class GPS {
    protected LocationManager locationManager;
    private String longitude, latitude;

    void initializeGPS(@Nullable Object context) throws NullPointerException {
        assert context != null;
        locationManager = (LocationManager) ((Context)context).getSystemService(LOCATION_SERVICE);

        // Vérification de pérmission
        if (ContextCompat.checkSelfPermission((Context)context, android.Manifest.permission.ACCESS_COARSE_LOCATION) != PackageManager.PERMISSION_GRANTED &&
                ContextCompat.checkSelfPermission((Context)context, android.Manifest.permission.ACCESS_FINE_LOCATION) != PackageManager.PERMISSION_GRANTED) {
            ActivityCompat.requestPermissions((Activity)context,
                    new String[]{android.Manifest.permission.ACCESS_COARSE_LOCATION,
                                 android.Manifest.permission.ACCESS_FINE_LOCATION}, 1);
        }
        locationManager.requestLocationUpdates(LocationManager.GPS_PROVIDER, 10, 1, location -> {
            longitude = String.valueOf(location.getLongitude());
            latitude = String.valueOf(location.getLatitude());
        });
    }

    public String coordinates(@Nullable Context context) {
        assert context != null;
        LocationManager loc = (LocationManager) (context).getSystemService(LOCATION_SERVICE);
        android.location.Location gpsLoc;
        double lat, lng;
        if (
                // Si la version d'Android est supportable et les permissions sont données
                // on récupère les coordonnées GPS
                android.os.Build.VERSION.SDK_INT >= Build.VERSION_CODES.M ||
                        (ContextCompat.checkSelfPermission(context, android.Manifest.permission.ACCESS_COARSE_LOCATION) != PackageManager.PERMISSION_GRANTED &&
                                ContextCompat.checkSelfPermission(context, android.Manifest.permission.ACCESS_FINE_LOCATION) != PackageManager.PERMISSION_GRANTED)
        ) {
            gpsLoc = loc.getLastKnownLocation(LocationManager.GPS_PROVIDER);
            lat = gpsLoc.getLatitude();
            lng = gpsLoc.getLongitude();
            longitude = Double.toString(lng);
            latitude = Double.toString(lat);
        }
        longitude += ", " + latitude;
        return longitude;
    }
}
