# Leads GAM/DFP Microservice

## Installation / Development
_Note:_ all commands should be run from the project root.

- Clone the repository
- Build the Docker image (only needs to be done once) by running `docker-compose build app`
- Install dependencies by running `scripts/composer.sh install`
- Create a `.env` file in the project root with the required environment variables (see below)
- Run the service container by running `docker-compose up app`

The service should now be available on `http://localhost:9017`

### Required Enviroment Variables
```sh
# The Google Ad Manager network code, e.g. 123456789
NETWORK_CODE=

# Must be an absolute path
JSON_KEY_FILE_PATH=
```

## Endpoints

### `/`
Returns a simple "ping/pong" JSON response:
```json
{
  "ping": "pong"
}
```

### `/_health`
Runs a "health" check by connecting to the configured Google Ad Manager network (based on the `NETWORK_CODE` env var):
```json
{
  "name": "[your network name]",
  "code": "[your network code/id]"
}
```

### `/creative-detail/{lineitem-id}/{creative-id}`
Returns creative, line item, and order details for the provided `lineitem-id` and `creative-id`:
```json
{
  "creative":{
    "id": "138258373333",
    "name": "Gateway_IENNow_Preroll_720",
    "type": "Video",
    "width": 1280,
    "height": 720,
    "previewUrl": null,
    "advertiser": {
      "id": "4686420190"
    },
    "order": {
      "id": "2476022764",
      "name": "Gateway_IENNow_Prerolls"
    },
    "lineitem": {
      "id": "4934467878",
      "name": "Gateway_IENNow_Preroll",
      "metrics": {
        "impressionsDelivered": 3761,
        "clicksDelivered": 33,
        "videoCompletionsDelivered": 1978,
        "videoStartsDelivered": 3761,
        "viewableImpressionsDelivered": 0
      },
      "startDate": 1548432960000,
      "createdDate": 1548432850000,
      "updatedDate": 1548437963000
    },
    "vastPreviewUrl": "[a long preview url]",
    "updatedDate": 1549298413000
  }
}
```
