  # Orizon APIs

![Static Badge](https://img.shields.io/badge/PHP-black?style=for-the-badge&logo=PHP)

## Description

This PHP project recreates the JSON RESTful APIs for the hypothetical Orizon travel agency.

## Installation

Open terminal and clone the Github repo:

```bash
git clone https://github.com/Gio-Mex/orizon-api.git
```

In the ```config``` folder you can find the ```migrations.sql``` file to import the database with some ready-to-use sample data regarding the countries in which the agency operates and the organized trips.

## API Usage

These APIs are designed for reading, inserting, updating (both case insensitive), and deleting countries and travels. You can apply filters on travels list.

### Countries

**Get all countries**

- Endpoint: `/countries`
- Method: `GET`

**Create a country**

- Endpoint: `/countries/`
- Method: `POST`
- Request Body: {'name': 'country name'}
**Update a country**

- Endpoint: `/countries?id={country Id}`
- Method: `PUT`
- Request Body: {'name': 'new country name'}

**Delete a country**

- Endpoint: `/countries?id={country Id}`
- Method: `DELETE`

### Travels

**Get all travels**

- Endpoint: `/travels`
- Method: `GET`

**Get a travel by route**

- Endpoint: `/travels?departure={country name}&destination={country name}`
- Method: `GET`

**Sort travels**

- Add `?sort={filter}` or `&sort={filter}`
- Method: `GET`
- Available filters: `departure`, `destination`, `available` (you can add `-asc` or `-desc` at the end of the filter).

**Create a travel**

- Endpoint: `/travels/`
- Method: `POST`
- Request Body: {   
  'departure': 'country name',  
  'destination': 'country name',  
  'available_places': 'number'   
  }

**Update a travel**

- Endpoint: `/travels?id={travel Id}`
- Method: `PUT`
- Request Body: {   
  'departure': 'new country name',  
  'destination': 'new country name',  
  'available_places': 'new number'  
  }

**Delete a travel**

- Endpoint: `/travels?id={travel Id}`
- Method: `DELETE`

You can test APIs using tools like Postman or HTTPie.