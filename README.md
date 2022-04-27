## About Nitaco Test

This is a small application for Nitaco Company to assess the programmer's ability to make Web services using Laravel.


## Documentation

### User Registration:
#### POST `` api/v1/register ``

#### `` JSON `` Request format
``` json
{
    "name"     : "your name",
    "email"    : "your email",
    "password" : "your password",
    "city"     : "your city"
}
```

#### `` JSON `` Response format
``` json
{
    "status" : "OK",
    "message": "Your registration was successful",
    "data" : {
        "name": "your name",
        "email": "your email",
        "city": "your city",
        "longitude": -0.091998,
        "latitude": 51.515618,
        "updated_at": "2022-04-27T12:46:28.000000Z",
        "created_at": "2022-04-27T12:46:28.000000Z",
        "id": 1
    }
}
```

---
### User Login
#### POST `` api/v1/login ``

#### `` JSON `` Request format
``` json
{
    "email"    : "your email",
    "password" : "your password",
}
```

#### `` JSON `` Response format
``` json
{
    "status" : "OK",
    "message": "Your information and access token is as follows:",
    "data" : {
        "user": {
            "id": 1,
            "name": "your name",
            "email": "your email",
            "email_verified_at": null,
            "city": "your city",
            "longitude": 51.4,
            "latitude": 35.7,
            "created_at": "2022-04-27T12:32:17.000000Z",
            "updated_at": "2022-04-27T12:32:17.000000Z"
        },
        "token": "your access token"
    }
}
```
