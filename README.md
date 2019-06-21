# UrlJR

## About

Basic URL shortening service. Only standard Laravel is used.

## Algorithms

### Short URL Generation

In this service in order to shorten an URL, URL's database id is used which is an unsigned number and converted to a short string of characters (default: a-z, A-Z, 0-9) with a fixed length (default: 6). Because of that the the short URLs will be sorted according to the characters provided. The following table will show you some examples:

<table>
<tr>
<th>ID</th>
<th>Short URL</th>
</tr>
<tr>
<td>1</td>
<td>aaaaab</td>
</tr>
<tr>
<td>2</td>
<td>aaaaac</td>
</tr>
<tr>
<td>3</td>
<td>aaaaad</td>
</tr>
<tr>
<td>...</td>
<td>...</td>
</tr>
<tr>
<td>26</td>
<td>aaaaaA</td>
</tr>
<tr>
<td>...</td>
<td>...</td>
</tr>
<tr>
<td>52</td>
<td>aaaaa0</td>
</tr>
<tr>
<td>...</td>
<td>...</td>
</tr>
<tr>
<td>62</td>
<td>aaaaba</td>
</tr>
</table>

### Hashing

In this service URLs are saved in database as blob(text) and because of that, searching for url will be slow. In order to fix that hashing algorithms have been used and indexed database table according to that. This way searching for a URL inside database is faster. The hashing algorithms that were used are SHA1 and MD5. In order to lower the possibility of the duplications, these 2 algorithms were used together (SHA1 of text + MD5 of text) which gives quite a unique string of 72 characters. Later this string is stored to database. Example:

text = "Hello World!"

**sha1**(text) = "2ef7bde608ce5404e97d5f042f95f89f1c232871"

**md5**(text) = "ed076287532e86365e841e92bfc50d8c"

**myHash**(text) = "2ef7bde608ce5404e97d5f042f95f89f1c232871ed076287532e86365e841e92bfc50d8c"

## Installation

### Requirements

- Docker
- Docker Compose

### Running Project

Please follow these steps to run this project:

1. Clone the project: `git clone https://github.com/lucky-bug/UrlJR`
2. Run docker compose: `docker-compose up -d --build`
3. Wait for composer to finish installing: `docker logs lemp-php -f`
4. Visit: http://localhost:8080
5. Enjoy :wink:

### Running Tests

Please follow these steps to run project tests:

1. Run docker compose or run `composer install` inside project's root directory.
2. Run `vendor/bin/phpunit`.
3. Enjoy :wink:

### Short URL Settings

You can change the default length and characters of the short URLs. Just add these to your .env file:

```
SHORT_URL_CHARACTERS={shortUrlCharacters}
SHORT_URL_LENGTH={shortUrlLength}
```

### Using Project

For the following examples cURL is used to send requests. You may also use Postman or any other application.

#### Get all URLs

Request:

```bash
curl localhost:8080/api/urls
```

Response:

```json
{
  "data": [
    {
      "real_url": "example1",
      "short_url": "http://localhost:8080/aaaaag",
      "view_counter": 0
    },
    {
      "real_url": "http://example2",
      "short_url": "http://localhost:8080/aaaaah",
      "view_counter": 0
    },
    {
      "real_url": "https://example3",
      "short_url": "http://localhost:8080/aaaaai",
      "view_counter": 0
    },
    {
      "real_url": "http://www.example4",
      "short_url": "http://localhost:8080/aaaaaj",
      "view_counter": 0
    },
    {
      "real_url": "https://www.example5",
      "short_url": "http://localhost:8080/aaaaak",
      "view_counter": 0
    }
  ]
}
```

#### Create new short URL

Request:

```bash
curl -d "real_url=http://google.com" localhost:8080/api/urls
```

Response:

```json
{
  "data": {
    "real_url": "https://google.com",
    "short_url": "http://localhost:8080/aaaaal",
    "view_counter": 0
  }
}
```

#### Get all own URLs

**WARNING!** In order for this request to work properly remember to get the session id from the cookies of the response when you create short URL.

Request:

```bash
curl --cookie "laravel_session={sessionId}" localhost:8080/api/urls/own
```

Response:

```json
{
  "data": [
    {
      "real_url": "https://www.google.com",
      "short_url": "http://localhost:8080/aaaaam",
      "view_counter": 0
    }
  ]
}
```

#### Using short URL

**Note:** You can use the `-L` or `--location` options of cURL to follow redirects.

Request:

```bash
curl localhost:8080/aaaaam
```

Response:

```html
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="refresh" content="0;url=https://www.google.com" />

        <title>Redirecting to https://www.google.com</title>
    </head>
    <body>
        Redirecting to <a href="https://www.google.com">https://www.google.com</a>.
    </body>
</html>
```

## Technical Limitations

This service's most technical limitations are server related, like storage, speed and etc. The only limitation that this service has is that each view counts for URLs are counted per session, so each session could only add 1 view to a URL.

