// ------------------------- dependency -------------------------
var Horseman   = require('node-horseman'),
    horseman   = new Horseman(),
    fs         = require('fs-extra'),
    isUrl      = require('is-url'),
    jsonPretty = require('json-pretty'),
    program    = require('commander'),
    http       = require('http-https'),
    cssLint    = require('csslint').CSSLint,
    // css        = require('css'),
    rte        = require('readtoend');

// --------------------------- get url ---------------------------
program
    .version('0.0.1')
    .option('-u, --url [url]', 'input url')
    .option('-d, --destination [path]', 'input path to store the output')
    .parse(process.argv);

var url     = program.url,
    dest;

if ( !isUrl(url) ) {
    console.log('ERROR: this is not an url');
    horseman.close();
    process.exit(1);
}

// initialization
var resultCSSLinter = {
    name    : 'CSS Linter',
    url     : url,
    checking: []
};

fs.exists(program.destination, function (exists) {
    if ( !exists ) {
        fs.mkdirsSync( program.destination );
    }
    dest = './' + program.destination;

    // download css asset
    var filenameCSS = url.substring( url.lastIndexOf('/') + 1 , url.length );

    var date = new Date();
    var time = date.getTime();
    var folderTemp = 'css' + time + '/';

    fs.mkdirSync(folderTemp);
    var file = fs.createWriteStream(folderTemp + filenameCSS);

    var request = http.get(url , function (response) {
        response.pipe(file);

        // read the file
        rte.readToEnd(response, function (err, body) {

            // beautify css
            // var parseSource = css.parse( body );
            // var beautified  = css.stringify( parseSource );

            // css lint, if use beautified css, change 'body' into 'beautified'
            var result = cssLint.verify( body );

            if (result.messages.length === 0) {
                // Success
            } else {
                // Errors or warnings
                for ( i = 0 ; i < result.messages.length ; i++) {
                    var message = result.messages[i];
                    resultCSSLinter.checking.push(
                        {
                            messageType     : message.type,
                            messageLine     : message.line,
                            messageCol      : message.col,
                            messageMsg      : message.message
                        }
                    );
                }
            }

            //beautify json
            var toJson = jsonPretty(resultCSSLinter);

            //save file
            fs.writeFile(dest + 'resultCSS.json', toJson, function (err) {
                if (err) throw err;
            }); 
            
            // remove asset file
            fs.remove('./' + folderTemp, function (err) {
                if (err) return console.log(err);
            });
        });
    });
});

// end of horseman
horseman.close();