# simpleWebServiceBasicAuth
simple web service
#test
*curl -X POST -H 'Authorization: Basic cm9vdDp0b29y' -v -i 'http://187.247.253.5/service/xml/senado'
*curl -X POST -H 'Authorization: Basic cm9vdDp0b29y' -H 'content-type: application/json' -d '{
	"clie":"senado",
	"per":"5742",
	"f":"2018-12-14",
	"cir":"2",
	"tip":"1"
}' -v -i 'http://187.247.253.5/service/data'
