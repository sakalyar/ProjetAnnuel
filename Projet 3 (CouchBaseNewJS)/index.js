// Load the Couchbase module
const couchbase = require('couchbase');

// Set up a connection to your Couchbase cluster
const cluster = new couchbase.Cluster('cb.xqwik2s-tivgqkg5.cloud.couchbase.com');
const bucket = cluster.bucket('birdsWatcherBucket');
const collection = bucket.scope('birdsWatcher').collection('watcher01');

// Create a new document in the collection
const newDoc = {
  email: 'yaroslav@univ-rouen.fr',
  password: 'password',
  birds: ['Linotte melodieuse', 'Pigeon']
};
collection.upsert('yaroslav', newDoc, (err, res) => {
  if (err) {
    console.error(err);
  } else {
    console.log('Document created!');
  }
});
