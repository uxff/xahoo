package main

import (
	"flag"
	"fmt"
	//"os"

	//feedreader "./feedreader"
	model "./model"
)

func main() {
	var url *string = flag.String("url", "", "feed url")
	flag.Parse()
	if url == nil || len(*url) == 0 {
		fmt.Println("url cannot be null")
		return
	}
	// set db
	//global.PathDB = ""
	//global.Init1()
	//global.Init2()
	// after this, its test model
	feed, items, e := model.FetchUrl(*url)
	succNum := model.SaveArticles(items)
        fmt.Println("feed ", succNum, "lines", "feed=", feed, "e=", e)
	/*
		// after this, its test feedreader.Fetch
		feed, err := feedreader.Fetch(*url)
		if err != nil {
			fmt.Fprintln(os.Stderr, err)
		} else {
			fmt.Println("feed title: ", feed.Title)

			fmt.Printf("There are %d item(s) in the feed\n", len(feed.Items))
			for _, i := range feed.Items {
				fmt.Println(i)
			}
		}
	*/
}
