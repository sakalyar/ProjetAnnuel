const couchbase = require('couchbase');

// Connect to the Couchbase cluster
const cluster = new couchbase.Cluster('couchbase://cb.xqwik2s-tivgqkg5.cloud.couchbase.com');
const bucket = cluster.bucket('birdsWatcher');
const collection = bucket.defaultCollection();

// Create a new document
const newDocument = {
  name: 'Yaroslav Sakal',
  email: 'yaroslav@univ-rouen.fr',
  password: 'password'
};
const newDocumentId = 'yaroslav-sakal';

collection.upsert(newDocumentId, newDocument).then(() => {
  console.log('New document created successfully');
}).catch((err) => {
  console.error('Error creating new document:', err);
});

// Update an existing document
const existingDocumentId = 'yaroslav-sakal';

collection.get(existingDocumentId).then((result) => {
  const updatedDocument = result.content;
  updatedDocument.age = 30;

  collection.replace(existingDocumentId, updatedDocument).then(() => {
    console.log('Existing document updated successfully');
  }).catch((err) => {
    console.error('Error updating existing document:', err);
  });
}).catch((err) => {
  console.error('Error retrieving existing document:', err);
});

// Retrieve a document
collection.get(newDocumentId).then((result) => {
  console.log('Retrieved document:', result.content);
}).catch((err) => {
  console.error('Error retrieving document:', err);
});
