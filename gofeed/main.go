package main

import (
	"flag"
	"fmt"
	"os"

	feedreader "./feedreader"
)

func main() {
	var url *string = flag.String("url", "", "feed url")
	flag.Parse()
	if url == nil || len(*url) == 0 {
		fmt.Println("url cannot be null")
		return
	}
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
}
