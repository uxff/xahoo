package model

import xorm "github.com/go-xorm/xorm"
import core "github.com/go-xorm/core"
import _ "github.com/mattn/go-sqlite3"
import h "github.com/m3ng9i/go-utils/http"
//import "crypto/md5"
import "time"
import _ "github.com/go-sql-driver/mysql"
import "fmt"
import (
	feedreader "../feedreader"
	//global "../global"
)

var Orm *xorm.Engine
var OrmEngine string
var OrmDB string
var NormalFetcher *h.Fetcher

func FetchUrl(url string) (feed *Feed, items []*ArticleEntity, err error) {

	headers := make(map[string]string)
	headers["User-Agent"] = "Gofeed: xahoo"//fmt.Sprintf("QReader %s (%s)", Version.Version, Github)

        NormalFetcher = h.NewFetcher(nil, headers)

	//msgNormally := fmt.Sprintf("[FETCH] Fetch feed '%s' normally", url)
	//msgProxy := fmt.Sprintf("[FETCH] Fetch feed '%s' behind proxy", url)
	/*
		if global.UseProxy == global.PROXY_ALWAYS {
			feed, items, err = fetchFeed(url, global.Socks5Fetcher)
			if err != nil {
				global.Logger.Errorf("%s: %s", msgProxy, err.Error())
			} else {
				global.Logger.Infof(msgProxy)
			}
			return
		}
	*/
	feed, items, err = fetchFeed(url, NormalFetcher)
	if err == nil {
		fmt.Println("feed error:", err)
		return
	}
	/*
		if err != nil {
			global.Logger.Errorf("%s: %s", msgNormally, err.Error())

			if global.UseProxy == global.PROXY_TRY {
				feed, items, err = fetchFeed(url, global.Socks5Fetcher)
				if err != nil {
					global.Logger.Errorf("%s: %s", msgProxy, err.Error())
				} else {
					global.Logger.Infof(msgProxy)
				}
			}
		}
	*/

	return
}

func fetchFeed(url string, fetcher *h.Fetcher) (feed *Feed, items []*ArticleEntity, err error) {
	fd, err := feedreader.Fetch(url, fetcher)
	if err != nil {
		return
	}

	feed, items = assembleFeed(fd)
	return
}

func assembleFeed(fd *feedreader.Feed) (feed *Feed, items []*ArticleEntity) {

	now := time.Now()

	feed = new(Feed)
	feed.Name = fd.Title
	feed.FeedUrl = fd.FeedLink
	feed.Url = fd.Link
	feed.Desc = fd.Description
	feed.Type = fd.Type
	feed.LastFetch = now

	for _, i := range fd.Items {
		var item = new(ArticleEntity)

		if i.Author != nil {
			item.Remark = i.Author.Name
		}

		item.Outer_url = i.Link
		//item.Guid = i.Guid
		item.Title = i.Title
		item.Content = i.Content
		item.Create_time = now
		item.Last_modified = now
/*
		item.Last_modified = i.PubDate
		if item.Last_modified.IsZero() {
			item.Last_modified = i.Updated
		}
		h := md5.New()
		fmt.Fprint(h, item.Content)
		//item.Hash = fmt.Sprintf("%x", h.Sum(nil))

*/
		items = append(items, item)
	}

	return
}

func SaveArticles(items []*ArticleEntity) (succNum int) {
	var err error
	succNum = 0

	OrmDB = "gofeed"
        selectedEngine := "mysql"
        if selectedEngine == "mysql" {
		Orm, err = xorm.NewEngine("mysql", "www:123x456@tcp(127.0.0.1:3306)/xahoo?charset=utf8")
	} else if selectedEngine == "sqlite3" {
		Orm, err = xorm.NewEngine("sqlite3", OrmDB)
	}
	if err != nil {
		fmt.Println("orm init error:", err)
		return
	}
	Orm.SetMapper(core.SameMapper{})




	//session := Orm.NewSession()
	for _, item := range items {
		num, e := Orm.Insert(item)
		if e != nil {
			fmt.Println("insert error:", e)
			continue
		}
                fmt.Println("insert success: num=", num, "all=", succNum, "id=", item.Id)
		succNum++
	}
	return
}
