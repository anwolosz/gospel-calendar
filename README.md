# Gospel Calendar API

Gospel Calendar is an open API that provides liturgical gospel reading data for each day, including liturgical colors. It is part of the [synopticus.org](https://www.synopticus.org) project. 

## Example
To fetch the gospel readings for a specific date, make a GET request to the following endpoint:

### Request
```
https://www.synopticus.org/gospel-calendar/api.php?date=2025-01-07
```

### Response
```json
{
  "date": "2025-01-07",
  "colors": [
    "white"
  ],
  "gospels": [
    {
      "evangelist": "mt",
      "intervals": [
        {
          "start": {
            "chapter": 4,
            "verse": "12"
          },
          "end": {
            "chapter": 4,
            "verse": "17"
          }
        },
        {
          "start": {
            "chapter": 4,
            "verse": "23"
          },
          "end": {
            "chapter": 4,
            "verse": "25"
          }
        }
      ]
    }
  ]
}
```

## Request

The API accepts requests for dates ranging from `1901-01-01` to `2100-12-31`. The date parameter is required and must be in `YYYY-MM-DD` format.

## Response
The API returns data in JSON format. Each response includes the following fields:

### Root Fields
- **date** (string): The date given in the request in `YYYY-MM-DD` format.
- **colors** (array of strings | null): List of liturgical colors for the day. Usually non-empty except on *Holy Saturday*, when it is `null`.
- **gospels** (array of objects): List of gospel passages data for the day.

### Gospel Object
Each object in the `gospels` array includes the following fields:

- **evangelist** (string): Two-letter abbreviation of the Gospel writer:
  - `mt` for Matthew
  - `mk` for Mark
  - `lk` for Luke
  - `jn` for John

- **intervals** (array of objects): List of passage intervals. Each interval includes:
  - **start** (object): Beginning of the passage.
    - `chapter` (integer): Chapter number.
    - `verse` (string): Verse number. Could end with char `a` or `b`
  - **end** (object): End of the passage.
    - `chapter` (integer): Chapter number.
    - `verse` (string): Verse number. Could end with char `a` or `b`
