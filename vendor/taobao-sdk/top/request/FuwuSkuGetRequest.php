<?php
/**
 * TOP API: taobao.fuwu.sku.get request
 * 
 * @author auto create
 * @since 1.0, 2015.12.17
 */
class FuwuSkuGetRequest
{
	/** 
	 * 应用注册在开放平台的的Appkey
	 **/
	private $appKey;
	
	/** 
	 * 服务code
	 **/
	private $articleCode;
	
	/** 
	 * 用户的淘宝nick
	 **/
	private $nick;
	
	private $apiParas = array();
	
	public function setAppKey($appKey)
	{
		$this->appKey = $appKey;
		$this->apiParas["appKey"] = $appKey;
	}

	public function getAppKey()
	{
		return $this->appKey;
	}

	public function setArticleCode($articleCode)
	{
		$this->articleCode = $articleCode;
		$this->apiParas["article_code"] = $articleCode;
	}

	public function getArticleCode()
	{
		return $this->articleCode;
	}

	public function setNick($nick)
	{
		$this->nick = $nick;
		$this->apiParas["nick"] = $nick;
	}

	public function getNick()
	{
		return $this->nick;
	}

	public function getApiMethodName()
	{
		return "taobao.fuwu.sku.get";
	}
	
	public function getApiParas()
	{
		return $this->apiParas;
	}
	
	public function check()
	{
		
		RequestCheckUtil::checkNotNull($this->appKey,"appKey");
		RequestCheckUtil::checkNotNull($this->articleCode,"articleCode");
		RequestCheckUtil::checkNotNull($this->nick,"nick");
	}
	
	public function putOtherTextParam($key, $value) {
		$this->apiParas[$key] = $value;
		$this->$key = $value;
	}
}
