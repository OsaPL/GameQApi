
# Simple GameQ Rest server

## Installation:
1. Run 'compose install' (or just update)
2. Generate autoload.php with 'composer dump-autoload -o' (-o is for production, can be omitted)
3. Profit!

## Running:
Should work under any recent webserver, simplest way is to just use built in webserver for Php (7.3 for example) and just run 'php -S localhost:8888'

## Api calls:

##### GET(/api/gameq/) : 
Returns state of servers, defined in server.json file (it has to be place in the same directory as index.php)

server.json file example:
[
  {
    "type": "minecraft",
    "host": "coolgamerguys.gov:25565"
  },
  {
    "type": "warsow",
    "host": "192.168.42.69:44400"
  }
]

##### POST(/api/gameq/) : 
Return state of server, nder this address.

Example body (raw,json)
{
	"type":"tf2",
	"ip":"enemiespotted.io",
	"port":"27015"
}

## Dependencies:
- Elementary framework (1.3 and up)
- GameQ library (3.0 and up)
