# devipsum

_Lorem ipsum for development. Randomly generated users, text, images, etc._

[devipsum.com](http://www.devipsum.com/)

# Request structure

```
api.devipsum.com/resource.json?param1=value1&param2=value2&etc
```

# User resource

_A random list of users_

__Example__: [api.devipsum.com/user.json?n=3](http://api.devipsum.com/user.json?n=3)

- __n__ (number of users)
	- default: 1
	- min: 1
	- max: 25

```json
{
	"request": {
		"action": "read",
		"resource": "user",
		"params": {
			"n": 3
		},
		"format": "json"
	},
	"result": {
		"users": [
			{
				"name": {
					"first": "Ryan",
					"last": "Flores",
					"full": "Ryan Flores"
				},
				"gender": "male",
				"birth": {
					"date": "1953-07-29T20:42:56+00:00",
					"age": 61,
					"ts": -518325424
				},
				"address": {
					"street": "5118 Maple Court",
					"city": "Sacramento",
					"state": "California",
					"country": "USA",
					"zip": 23267
				},
				"contact": {
					"phone": "(664) 224-2536",
					"email": "rflores@zoho.com",
					"social": {
						"profile": "http://img.devipsum.com/profile/male-35.png",
						"google": "http://plus.google.com/+rflores",
						"facebook": "http://www.facebook.com/rflores",
						"twitter": "http://twitter.com/rflores"
					},
					"website": "http://www.rflores.com/"
				}
			},
			{
				"name": {
					"first": "Mike",
					"last": "Rice",
					"full": "Mike Rice"
				},
				"gender": "male",
				"birth": {
					"date": "1967-06-30T15:40:05+00:00",
					"age": 47,
					"ts": -79085995
				},
				"address": {
					"street": "7807 Fifth Street",
					"city": "Manchester",
					"state": "New Hampshire",
					"country": "USA",
					"zip": 61668
				},
				"contact": {
					"phone": "(691) 275-2899",
					"email": "mrice@yahoo.com",
					"social": {
						"profile": "http://img.devipsum.com/profile/male-34.png",
						"google": "http://plus.google.com/+mrice",
						"facebook": "http://www.facebook.com/mrice",
						"twitter": "http://twitter.com/mrice"
					},
					"website": "http://www.mrice.com/"
				}
			},
			{
				"name": {
					"first": "Walter",
					"last": "Hill",
					"full": "Walter Hill"
				},
				"gender": "male",
				"birth": {
					"date": "1982-02-03T08:58:20+00:00",
					"age": 32,
					"ts": 381574700
				},
				"address": {
					"street": "2562 Park Way",
					"city": "Concord",
					"state": "New Hampshire",
					"country": "USA",
					"zip": 44933
				},
				"contact": {
					"phone": "(707) 575-1655",
					"email": "whill@inbox.com",
					"social": {
						"profile": "http://img.devipsum.com/profile/male-9.png",
						"google": "http://plus.google.com/+whill",
						"facebook": "http://www.facebook.com/whill",
						"twitter": "http://twitter.com/whill"
					},
					"website": "http://www.whill.com/"
				}
			}
		]
	},
	"status": {
		"code": 200,
		"message": "OK",
		"reason": "",
		"ttl": 14
	}
}
```

# Text resource

_Random lorem ipsum / latin text_

__Example__: [api.devipsum.com/text.json?n=2](http://api.devipsum.com/text.json?n=2)

- __n__ (number of paragraphs)
	- default: 1
	- min: 1
	- max: 10

_Response structure_
```json
{
	"request": {
		"action": "read",
		"resource": "text",
		"params": {
			"n": 2
		},
		"format": "json"
	},
	"result": {
		"text": [
			"Rem molestias praesentiu expedita rem facere cumque amet. Expedita facere irure provident quod nihil distinctio voluptatib. Placeat ex a saepe corrupti provident. Deserunt provident excepturi. Voluptate dolor quibusdam voluptatib corrupti hic optio repellat.",
			"Unde amet molestiae nostrud molestias consectetu tenetur nam. Expedita dicta inventore eaque ipsum similique. Dicta voluptate quaerat vero ullamco exercitati."
		]
	},
	"status": {
		"code": 200,
		"message": "OK",
		"reason": "",
		"ttl": 14
	}
}
```
