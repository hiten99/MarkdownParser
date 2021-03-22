<?php

class Parser {
	private $tags='h|p';

	public function render(String $text):String {
		//split by blank lines
		$data = preg_split("/^\s+/m", $text); 

		foreach($data as $key=>$row){
			// ignore blank lines
			if(empty($row)){continue;}
			
			//adding paragraph
			$addParagraph=Parser::addParagraph($row);
			if(!empty($addParagraph)){
				$data[$key] = $addParagraph;
			}
			//adding heading
			$addHeading = Parser::addHeading($row);
			if(!empty($addHeading)){
				$data[$key]= $addHeading;		
			}

			
		}
		//imploding array with new line
		$text = implode("\n",$data);
		//regex for links
		$text = Parser::addLink($text);

		return $text;
	}
	
	public function addHeading(String $row ){
		//get count of # if in range [0,7] add headers based on count else ignore
		$headerCount= substr_count(substr($row, 0),'#');
		if($headerCount>0 && $headerCount<7){
			return "<h".$headerCount.">".trim(substr($row,$headerCount))."</h".$headerCount.">";
		}
		
	}
	
	public function addParagraph(String $row){
		//if input does not contains starting tags like h or p add p tag else ignore
		if (!preg_match ('/^<\/?('.$this->tags.')/', $row)) {
				return "<p>".trim($row)."</p>";
			}
	}
	
	public function addLink(String $text):String{
		return preg_replace('/\[(.*)\]\((.*)\)/','<a href="\2">\1</a>',$text);
	}
}

$parser=new Parser();
$file = file_get_contents('./input.txt', FILE_USE_INCLUDE_PATH);
$result = $parser->render($file);
echo $result;
file_put_contents('./output.md', $result);

