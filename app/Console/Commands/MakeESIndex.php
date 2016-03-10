<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class MakeESIndex extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'es:create-index';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->warn('ES is starting to build app index');

	    // Example Index Mapping
	    $myTypeMapping = [
		    '_source' => [
			    'enabled' => true
		    ],
		    "_id" => [
		        "path" => "id"
	        ],
		    'properties' => [
			    'title' => [
				    'type' => 'multi_field',
				    "fields" => [
						'title' => [
							'type' => 'string',
							'term_vector' => 'yes',
							'copy_to' => 'combined'
						],
					    //only not_analyzed fields can be sorted
					    'raw_title' => [
						    'type' => 'string',
						    'index' => 'not_analyzed'
					    ]
				    ]
			    ],
			    'description' => [
				    'type' => 'string',
				    'term_vector' => 'yes',
				    'copy_to' => 'combined'
			    ],
			    'combined' => [
				    'type' => 'string',
				    'term_vector' => 'yes'
			    ],
			    'type' => [
				    'type' => 'string',
				    'index' => 'not_analyzed'
			    ],
			    'year' => [
				    'type' => 'integer',
				    'index' => 'not_analyzed'
			    ],
			    'released' => [
				    'type' => 'date',
				    'index' => 'not_analyzed',
				    "format" => "YYYY-MM-dd"
			    ],
			    'imdb_votes' => [
				    'type' => 'integer',
				    'index' => 'not_analyzed'
			    ],
			    'imdb_rating' => [
				    'type' => 'integer',
				    'index' => 'not_analyzed'
			    ],
			    'poster' => [
				    'type' => 'string',
				    'index' => 'not_analyzed'
			    ],
			    'country' => [
				    'type' => 'string',
				    'index' => 'not_analyzed'
			    ]
		    ]
	    ];

	    if (app('elasticsearch')->indices()->exists(['index' => 'myimdb']))
	    {
		    $deleteParams['index'] = 'myimdb';

		    app('elasticsearch')->indices()->delete($deleteParams);
	    }

	    $indexParams['index'] = 'myimdb';
	    $indexParams['body']['mappings']['movies'] = $myTypeMapping;

	    app('elasticsearch')->indices()->create($indexParams);

	    $this->warn('ES has built indexes');
    }
}
