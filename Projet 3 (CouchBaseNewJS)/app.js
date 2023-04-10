const couchbase = require('coachbase')

// function return the element by its id
function $(id){
	return document.getElementById(id);
}
var emails = ["admin"]
var passwords = ["password"]
// put cursor in the first textbox
window.onload = function(){
	$('email_address').focus();
}
// deactivate the submit event
$('email_form').addEventListener('submit',function(e){
	e.preventDefault();
});
// do validation
$('email_list').addEventListener('click',Validation);
function Validation(){
	const email_address = $('email_address').value.trim();
	const password = $('password').value.trim();
	const birds = $('birds').value.trim();
	let isValid = true;

		if(!emails.contains(email_address) || !passwords.contains(password)){
			$('email_address_error').innerHTML = 'Incorrect credentials!';
			isValid = false;
		}else{
			$('email_address_error').innerHTML = '*';
		}

		if(isValid){
            main()
            .catch((err) => {
            console.log('ERR:', err)
            process.exit(1)
            })
            .then(process.exit)
			$('email_form').submit();
		}
}

async function main() {
    const clusterConnStr = 'couchbase://localhost'
    const username = $('email_address')
    const password = $('password')
    const bucketName = $('birds')
  
    const cluster = await couchbase.connect(clusterConnStr, {
      username: username,
      password: password,
    })
  
    const bucket = cluster.bucket(bucketName)
  
    // Get a reference to the default collection, required only for older Couchbase server versions
    const defaultCollection = bucket.defaultCollection()
  
    const collection = bucket.scope('forms').collection('watchers')
  
    const user = {
      type: 'user',
      name: 'Yaroslav222222222222',
      email: 'yaroslav2333333333333@univ-rouen.com',
      birdsWatched: ['Linotte', 'Pigeon', 'Falcon', 'nouveau oiseau'],
    }
  
    // Create and store a document
    await collection.upsert('yaroslav', user)
  
  }
  
  // Run the main function
  