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
    "http_status": 201,
    "http_message": "Created",
    "message": "Your registration was successful",
    "data": {
        "name": "your name",
        "email": "your email",
        "city": "your city",
        "longitude": 51.67917,
        "latitude": 32.65139,
        "updated_at": "2022-04-29T07:05:15.000000Z",
        "created_at": "2022-04-29T07:05:15.000000Z",
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
    "http_status": 200,
    "http_message": "OK",
    "message": "Your information and access token is as follows:",
    "data": {
        "user": {
            "id": 1,
            "name": "your name",
            "email": "your email",
            "email_verified_at": null,
            "city": "your city",
            "longitude": 51.68,
            "latitude": 32.65,
            "created_at": "2022-04-27T10:02:29.000000Z",
            "updated_at": "2022-04-27T10:02:29.000000Z"
        },
        "token": "your access token"
    }
}
```
