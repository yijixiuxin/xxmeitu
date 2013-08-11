<?php

class xmeituLib extends img {
	public function __construct() {
		parent::__construct();
		set_time_limit(0);
	}

	public function xinggan($yuan, $lei) {
		$topPage = $this->curlGet($lei['lurl']);
		if (empty($topPage)) {
			echo $lei['lurl'].'获取数据失败<br>';return false;
		}
		//获取所有分页
		$links = $this->getPageList($lei['lurl'], $topPage);
		if (empty($links)) {
			echo 'xinggan 获取分页信息失败';return false;
		}
		foreach ($links as $pageUrl) {
			$pageStr = $this->curlGet($pageUrl);
			$articleList = $this->getPageArticle($yuan['url'], $pageStr);
			foreach ($articleList as $articleUrl) {
				$articleStr = $this->curlGet($articleUrl);
				$picPages = $this->getPicPage($articleUrl, $articleStr);
				echo $articleUrl,' is OK<br>';
				$tid = $this->addTuji($this->getPageTitle($articleStr), $lei['lid'], $yuan['yid'], $articleUrl);
				foreach ($picPages as $pageUrl) {
					if ($this->checkCaiji($pageUrl)) continue;
					$picStr = $this->curlGet($pageUrl);
					$picInfo = $this->getPicInfo($yuan['url'], $picStr);
					if ($picInfo == false) {
						echo 'PicInfo get False <br>';
						continue;
					}
					$res = $this->addPicDb($tid, $picInfo['title'], $picInfo['imgUrl'], $yuan['yid'], $lei['lid']);
					if ($res == false) {
						echo $pageUrl.' is Fail<br/>';
					}
					echo $pageUrl,' is OK<br>';
					$this->addCaiji($pageUrl);
				}
			}
		}
	}

	public function getPageTitle($page) {
		preg_match_all('/<title>(.+)<\/title>/s', $page, $title);
		$title = mb_convert_encoding($title[1][0], 'UTF-8', 'GB2312');
		$title = str_replace('_x美图', '', $title);
		return $title;
	}

	public function getPicInfo($url, $page) {
		preg_match_all('/<title>(.+)<\/title>/s', $page, $title);
		$title = mb_convert_encoding($title[1][0], 'UTF-8', 'GB2312');
		$title = str_replace('_x美图', '', $title);
		preg_match_all('/<img src=\'([\/a-zA-Z0-9-_\.]+)\' id=\'bigimg\'/', $page, $img);
		$imgUrl = trim($url, '/').$img[1][0];
		return array('title' => $title, 'imgUrl' => $imgUrl);
	}

	public function getPicPage($url, $page) {
		preg_match_all('/<li><a href=\'([0-9_]+\.html)\'>[0-9]+<\/a><\/li>/', $page, $pages);
		$turl = substr($url, 0, strrpos($url, '/') + 1);
		$pageList = array($url);
		if (empty($pages[1])) return $pageList;
		foreach ($pages[1] as $p) {
			$pageList[] = $turl.$p;
		}
		return $pageList;
	}

	public function getPageArticle($url, $page) {
		preg_match_all('/<dd><a href=\"([a-zA-z0-9\/]+\.html)\" target=\"\_blank\"/', $page, $links);
		if (empty($links[1])) return false;
		$linkList = array();
		foreach ($links[1] as $l) {
			$linkList[] = trim($url, '/').$l;
		}
		return $linkList;
	}

	public function getPageList($url, $page) {
		preg_match_all('/<li><a href=\'(list_[0-9]+_[0-9]+.html)\'>([0-9]+)<\/a><\/li>/', $page, $links);
		$linkList = array($url);
		if (empty($links[1])) return $linkList;
		foreach ($links[1] as $l) {
			$linkList[] = $url.$l;
		}
		return $linkList;
	}
}