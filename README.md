# devipsum

_Lorem ipsum for development. Randomly generated users, text, images, etc._

[devipsum.com](http://www.devipsum.com/)

# Request structure

```
api.devipsum.com/resource.json?param1=value1&param2=value2&etc
```

# User resource

_A random list of users_

__Example__: [api.devipsum.com/user.json?n=10](http://api.devipsum.com/user.json?n=10)

- __n__ (number of users)
  - default: 1
  - min: 1
  - max: 25

# Text resource

_Random lorem ipsum / latin text_

__Example__: [api.devipsum.com/text.json?n=5](http://api.devipsum.com/text.json?n=5)

- __n__ (number of paragraphs)
  - default: 1
  - min: 1
  - max: 10
