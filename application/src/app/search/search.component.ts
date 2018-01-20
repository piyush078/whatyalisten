import { Component, OnInit } from '@angular/core';

import { ApiService } from '../api.service';

@Component ({
  selector: 'search',
  templateUrl: './search.component.html',
  styleUrls: ['./search.component.css']
})

export class SearchComponent implements OnInit {

  /**
   * Variables for parameters for search.
   *
   * @var mixed
   */
  private response: Object;
  private title: string;
  private limit: number = 1;
  private type: string; 
  private URL = 'search';

  constructor (private api: ApiService) {}
  ngOnInit () {}

  /**
   * Make the parameters for search.
   *
   * @param  void
   * @return array
   */
  makeParams (): string[] {
    let query: string[] = [];
    query ['type'] = this.type;
    query ['title'] = this.title;
    query ['limit'] = this.limit;
    return query;
  }

  /**
   * Get the search parameters and call the function for the search request.
   *
   * @param  void
   * @return void
   */
  search (): void {
    this.sendRequest (
      this.makeParams ()
    );
  }

  /**
   * Send the search request to service provider.
   *
   * @param  array
   * @return void
   */
  sendRequest (query: string[]): void {
    this.api.fetchData (this.URL, query).subscribe (
      data => console.log (data),
      error => console.log (error)
    );
  }
}
